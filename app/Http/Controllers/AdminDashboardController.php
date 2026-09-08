<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Borrowing;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_copies'     => Book::sum('available_copies'), // تأكدي لو العمود اسمه available_copies غيريه هنا
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
            'total_borrowings' => Borrowing::count(),
        ];

        $recent_books = Book::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_books'));
    }
}