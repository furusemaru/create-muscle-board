<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[PostController::class,'index'])->name('index');
Route::get('/posts/{post}',[PostController::class,'show']);

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    //Route::get('/', 'index')->name('index');
    //Route::post('/posts', 'store');
    //Route::get('/posts/create', 'create');
    //Route::get('/posts/{post}', 'show')->name('show');
    //Route::put('/posts/{post}', 'update');
    //Route::delete('/posts/{post}', 'delete');
    //Route::get('/posts/{post}/edit', 'edit');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
