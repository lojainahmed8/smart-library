<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');

        $query = Book::with('category');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $rawBooks = $query->latest()->get();
        $categories = Category::all();

        $displayInterests = 'Not specified yet';
        $userText = '';
        $borrowedBookIds = [];

        if (Auth::check()) {
            $user = Auth::user();

            
            $borrowedBookIds = Borrowing::where('user_id', $user->id)
                ->whereNull('returned_at')
                ->pluck('book_id')
                ->toArray();

            
            $profileParts = array_filter([
                $user->preferred_book_categories ?? null,
                $user->favorite_topics ?? null,
                $user->interests ?? null,
                $user->skills ?? null,
                $user->educational_interests ?? null,
                $user->learning_goals ?? null,
            ]);

            if (!empty($profileParts)) {
                $userText = strtolower(implode(' ', $profileParts));
                $displayInterests = ucwords(reset($profileParts));
            }
        }

        
        $books = $rawBooks->map(function ($book) use ($userText, $borrowedBookIds) {
            $book->is_borrowed_by_user = in_array($book->id, $borrowedBookIds);

            if (empty(trim($userText))) {
                $book->match_percentage = 50;
                return $book;
            }

            $bookCategory = strtolower($book->category->name ?? '');
            $bookTitle    = strtolower($book->title ?? '');
            $bookDesc     = strtolower($book->description ?? '');
            $bookContent  = $bookCategory . ' ' . $bookTitle . ' ' . $bookDesc;

            $score = 40;

           
            if (!empty($bookCategory)) {
                $categoryWords = array_unique(array_filter(
                    explode(' ', preg_replace('/[^a-z0-9]/', ' ', $bookCategory)),
                    fn($w) => strlen($w) > 2
                ));

                $userWords = array_unique(array_filter(
                    explode(' ', preg_replace('/[^a-z0-9]/', ' ', $userText)),
                    fn($w) => strlen($w) > 2
                ));

                $categoryMatchCount = 0;
                foreach ($categoryWords as $cw) {
                    foreach ($userWords as $uw) {
                        if (str_contains($cw, $uw) || str_contains($uw, $cw)) {
                            $categoryMatchCount++;
                            break;
                        }
                    }
                }

                if (count($categoryWords) > 0) {
                    $matchRatio = $categoryMatchCount / count($categoryWords);

                    if ($matchRatio >= 0.5) {
                        $score += 40;
                    } elseif ($matchRatio > 0) {
                        $score += 20;
                    }
                }
            }

           
            $keywords = array_unique(array_filter(explode(' ', preg_replace('/[^a-z0-9]/', ' ', $userText))));
            $matches = 0;

            foreach ($keywords as $word) {
                if (strlen($word) > 2 && str_contains($bookContent, $word)) {
                    $matches++;
                }
            }

            if ($matches >= 2) {
                $score += 18;
            } elseif ($matches == 1) {
                $score += 10;
            }

            $score = min($score, 98);
            $score = max($score, 35);

            $book->match_percentage = $score;
            return $book;
        });

        $books = $books->sortByDesc('match_percentage')->values();

        return view('home', compact('books', 'categories', 'search', 'categoryId', 'displayInterests'));
    }
}
