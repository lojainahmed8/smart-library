<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('book.category')
            ->where('user_id', Auth::id())
            ->whereNull('returned_at')  
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrowed-books', compact('borrowings'));
    }

    
    public function store(Request $request, Book $book)
    {
        
        $availableCopies = $book->available_copies ?? ($book->is_available ? 1 : 0);

        if ($availableCopies <= 0) {
            return back()->with('error', 'This book is currently unavailable.');
        }

        
        Borrowing::create([
            'user_id'     => Auth::id(),
            'book_id'     => $book->id,
            'borrowed_at' => now(),
            'due_date'    => now()->addDays(14), 
            'status'      => 'borrowed',
        ]);

        
        if (isset($book->available_copies)) {
            $newAvailable = max(0, $book->available_copies - 1);
            $book->update([
                'available_copies' => $newAvailable,
                'is_available'     => $newAvailable > 0,
            ]);
        } else {
            $book->update(['is_available' => false]);
        }

        return back()->with('success', 'Book borrowed successfully!');
    }

     
    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }


        $borrowing->update([
            'returned_at' => now(),
            'status'      => 'returned',
        ]);

        
        $book = $borrowing->book;
        if (isset($book->available_copies)) {
            $newAvailable = $book->available_copies + 1;
            $book->update([
                'available_copies' => $newAvailable,
                'is_available'     => true,
            ]);
        } else {
            $book->update(['is_available' => true]);
        }

        return back()->with('success', 'Book returned successfully!');
    }
}
