<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    // عرض الكتب المستعارة حالياً فقط الخاصة بالمسجل حالياً
    public function index()
    {
        $borrowings = Borrowing::with('book.category')
            ->where('user_id', Auth::id())
            ->whereNull('returned_at') // يعرض فقط الكتب التي لم يتم إرجاعها بعد
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrowed-books', compact('borrowings'));
    }

    // عملية استعارة كتاب
    public function store(Request $request, Book $book)
    {
        // التأكد من وجود نسخ متاحة للاستعارة
        $availableCopies = $book->available_copies ?? ($book->is_available ? 1 : 0);

        if ($availableCopies <= 0) {
            return back()->with('error', 'This book is currently unavailable.');
        }

        // إنشاء سجل الاستعارة
        Borrowing::create([
            'user_id'     => Auth::id(),
            'book_id'     => $book->id,
            'borrowed_at' => now(),
            'due_date'    => now()->addDays(14), // مدة الاستعارة 14 يوم
            'status'      => 'borrowed',
        ]);

        // تحديث عدد النسخ المتاحة وحالة الكتاب
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

    // إرجاع الكتاب
    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        // تحديث حالة الاستعارة لتصبح أُرجِعت
        $borrowing->update([
            'returned_at' => now(),
            'status'      => 'returned',
        ]);

        // إرجاع النسخة لزيادة عدد النسخ المتاحة وجعل الكتاب متاحاً
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