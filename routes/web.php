<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AIController; // تم إضافة الـ AIController هنا
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Welcome Page (Public Guest View)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 2. Public Home Page (General Book Catalog & Search)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 3. User & Admin Authenticated Redirect Handling
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Redirect logic for '/dashboard' route
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Borrowing System Routes
    Route::get('/my-borrowed-books', [BorrowController::class, 'index'])->name('borrowed.index');
    Route::post('/books/{book}/borrow', [BorrowController::class, 'store'])->name('books.borrow');
    Route::post('/borrowings/{borrowing}/return', [BorrowController::class, 'returnBook'])->name('books.return');

    // AI Chatbot Route (المسار المحمي الخاص بالشات بوت)
    Route::post('/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
});

// 4. Admin Only Routes Group
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Resource Routes
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';