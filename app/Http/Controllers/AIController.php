<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AiController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $userMessage = trim($request->input('message'));

        // 1. تجميع البيانات
        $categories = Category::pluck('name')->toArray();
        $categoriesList = !empty($categories) ? implode(', ', $categories) : 'None';

        if ($user->role === 'admin') {
            $books = Book::all(['id', 'title', 'author', 'publication_date', 'available_copies']);
            $usersCount = User::count();

            $booksList = [];
            foreach ($books as $b) {
                $booksList[] = "Title: {$b->title} | Author: {$b->author} | Copies: {$b->available_copies}";
            }
            $booksText = implode("\n", $booksList);

            $systemPrompt = "You are the Admin Assistant for Smart Library System.\n" .
                "System Stats: Total Users = {$usersCount}.\n" .
                "Categories: {$categoriesList}.\n" .
                "Books Catalog:\n{$booksText}\n\n" .
                "Instructions:\n" .
                "- Answer any admin question about users, stats, categories, or books accurately.\n" .
                "- Match partial title searches directly.";
        } else {
            $books = Book::where('available_copies', '>', 0)->get(['title', 'author', 'available_copies']);

            $booksList = [];
            foreach ($books as $b) {
                $booksList[] = "Title: {$b->title} | Author: {$b->author} | Copies: {$b->available_copies}";
            }
            $booksText = implode("\n", $booksList);

            // تجميع بيانات بروفايل المستخدم عشان الـ AI يرشح كتب مباشرة بدل ما يسأل عن اهتماماته
            $profileParts = array_filter([
                'Interests' => $user->interests ?? null,
                'Favorite Topics' => $user->favorite_topics ?? null,
                'Preferred Book Categories' => $user->preferred_book_categories ?? null,
                'Skills' => $user->skills ?? null,
                'Educational/Professional Interests' => $user->educational_interests ?? null,
                'Learning Goals' => $user->learning_goals ?? null,
            ]);

            if (!empty($profileParts)) {
                $profileLines = [];
                foreach ($profileParts as $label => $value) {
                    $profileLines[] = "{$label}: {$value}";
                }
                $profileText = implode("\n", $profileLines);
            } else {
                $profileText = 'The user has not set up their profile preferences yet.';
            }

            $systemPrompt = "You are the User Assistant for Smart Library System.\n" .
                "Categories: {$categoriesList}.\n" .
                "Available Books Catalog:\n{$booksText}\n\n" .
                "This User's Profile (use this to personalize recommendations automatically, without asking the user what they like):\n{$profileText}\n\n" .
                "STRICT RULES:\n" .
                "1. Answer queries regarding books, authors, availability, categories, and recommendations.\n" .
                "2. If asked about system statistics or user counts, reply strictly: 'Access Denied: You do not have administrator privileges to view system metrics.'\n" .
                "3. If asked 'who wrote X' or 'author of X', state the author directly without dumping all books.\n" .
                "4. When asked for a recommendation (e.g. 'recommend me a book', 'what should I read'), use the User's Profile above to pick books from the Available Books Catalog that best match their interests/skills/goals — do NOT ask the user what topics they like, since their profile is already known.";
        }

        // 2. دمج التعليمات مع سؤال المستخدم في طلب واحد مباشر
        $fullPrompt = $systemPrompt . "\n\nUser Question: " . $userMessage;

        // 3. إرسال الطلب لـ API
        try {
            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return response()->json(['reply' => 'GEMINI_API_KEY is not configured in .env'], 500);
            }

            // نجرب أكتر من موديل بالترتيب، لو الأول مزدحم (503) ننتقل تلقائيًا للتاني
            $modelsToTry = ['gemini-3.5-flash', 'gemini-2.5-flash', 'gemini-2.0-flash'];

            $body = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $fullPrompt]
                        ]
                    ]
                ]
            ];

            $response = null;
            $lastStatus = null;
            $lastBody = null;

            foreach ($modelsToTry as $model) {
                $response = Http::timeout(30)
                    ->retry(2, 1000)
                    ->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                        $body
                    );

                if ($response->successful()) {
                    $reply = $response->json('candidates.0.content.parts.0.text');
                    return response()->json(['reply' => trim($reply)]);
                }

                $lastStatus = $response->status();
                $lastBody = $response->body();

                // لو المشكلة ازدحام (503) أو الموديل مش موجود (404)، جربي الموديل التالي
                // أي خطأ تاني (زي 400 غلط في الطلب نفسه) وقفي فورًا وارجعي الخطأ
                if (!in_array($lastStatus, [503, 404, 429])) {
                    break;
                }
            }

            // لو كل الموديلات فشلت
            if ($lastStatus === 503 || $lastStatus === 429) {
                return response()->json([
                    'reply' => 'The AI service is currently busy. Please wait a few seconds and try again.'
                ], 503);
            }

            return response()->json(['reply' => 'API Error: ' . $lastStatus . ' - ' . $lastBody], 500);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'reply' => 'Connection to the AI service failed. Please check your internet connection and try again in a moment.'
            ], 503);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}