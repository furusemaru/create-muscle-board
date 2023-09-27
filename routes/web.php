<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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



Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    //Route::get('/', 'index')->name('index');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');
    //Route::get('/posts/{post}', 'show')->name('show');
    Route::put('/posts/{post}', 'update')->name('update');
    Route::delete('/posts/{post}', 'delete')->name('delete');
    Route::get('/posts/{post}/edit', 'edit')->name('edit');
    Route::get('/my_posts','my_posts')->name('my_posts');
    Route::get('/related_posts','related_posts')->name('related_posts');
    //URL落ち着いたらなおしたい
    Route::get('/posts/{post}/like','like')->name('posts.like');
    Route::get('/posts/{post}/unlike','unlike')->name('posts.unlike');
    Route::get('/posts/{post}/report','report')->name('posts.report');
    Route::get('/posts/{post}/unreport','unreport')->name('posts.unreport');
});

//Route::post('/post/comment/store',[CommentController::class,'store'])->name('comment');
Route::controller(CommentController::class)->middleware(['auth'])->group(function(){
    //コメント投稿処理
    Route::post('/posts/comment','store')->name('comment.store');
    //コメント取消処理
    Route::delete('/comments/{comment_id}', 'delete')->name('comment.delete');
});


Route::get('/',[PostController::class,'index'])->name('index');
Route::get('/posts/{post}',[PostController::class,'show']);
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
Route::get('/dashboard',[UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
