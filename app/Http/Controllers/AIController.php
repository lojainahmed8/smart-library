<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json(['reply' => 'Unauthorized access.'], 401);
            }

            $userPrompt = strtolower(trim($request->input('message')));

            // ==========================================
            // 1. حظر اليوزر العادي من أسئلة الأدمن (RBAC)
            // ==========================================
            $adminOnlyKeywords = [
                'user', 'users', 'registered', 'metrics', 'count', 
                'most books', 'highest', 'stats', 'analytics', 
                'عدد', 'المستخدمين', 'الأكثر'
            ];

            if ($user->role !== 'admin') {
                foreach ($adminOnlyKeywords as $keyword) {
                    if (str_contains($userPrompt, $keyword)) {
                        return response()->json([
                            'reply' => 'Access Denied: You do not have administrator privileges to view system metrics, user data, or library analytics.'
                        ]);
                    }
                }
            }

            // ==========================================
            // 2. منطق الأدمن (Admin Full Access)
            // ==========================================
            if ($user->role === 'admin') {
                // سؤال: أي تصنيف يحتوي على أكبر عدد من الكتب؟
                if (str_contains($userPrompt, 'most books') || str_contains($userPrompt, 'highest category') || str_contains($userPrompt, 'top category')) {
                    $topCategory = Category::withCount('books')
                        ->orderBy('books_count', 'desc')
                        ->first();

                    if ($topCategory) {
                        return response()->json([
                            'reply' => "Hello Admin {$user->name}! The category with the most books is '{$topCategory->name}' with {$topCategory->books_count} books."
                        ]);
                    }
                }

                // سؤال: عدد المستخدمين والكتب والكتالوج
                if (str_contains($userPrompt, 'user') || str_contains($userPrompt, 'registered') || str_contains($userPrompt, 'metrics') || str_contains($userPrompt, 'count')) {
                    $usersCount = User::count();
                    $booksCount = Book::count();
                    return response()->json([
                        'reply' => "Hello Admin {$user->name}! System Overview: Total Users = {$usersCount}, Total Books = {$booksCount}."
                    ]);
                }
            }

            // ==========================================
            // 3. استعلامات الكتب والمواد التعليمية (الجميع)
            // ==========================================
            if (str_contains($userPrompt, 'book') || str_contains($userPrompt, 'programming') || str_contains($userPrompt, 'available') || str_contains($userPrompt, 'كتب')) {
                $books = Book::pluck('title')->toArray();
                if (!empty($books)) {
                    $bookList = implode(', ', $books);
                    return response()->json([
                        'reply' => "Hello {$user->name}! The available books in our library catalog are: {$bookList}."
                    ]);
                }
                return response()->json(['reply' => "Hello {$user->name}! Currently, no books are available."]);
            }

            if (str_contains($userPrompt, 'category') || str_contains($userPrompt, 'categories') || str_contains($userPrompt, 'قسم')) {
                $categories = Category::pluck('name')->toArray();
                if (!empty($categories)) {
                    $catList = implode(', ', $categories);
                    return response()->json([
                        'reply' => "Available categories in the library: {$catList}."
                    ]);
                }
            }

            // ==========================================
            // 4. الرد الافتراضي الذكي
            // ==========================================
            return response()->json([
                'reply' => "Hello {$user->name}! I am your Smart Library Assistant. Ask me about available books, authors, or categories."
            ]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}