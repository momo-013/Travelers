<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//home
Route::controller(Postcontroller::class)->middleware(['auth'])->group( function () {
    Route::get('/','index')->name('index');
    Route::get('/posts/follow','follow');
    Route::get('/posts/create','create')->name('create');
    Route::post('/posts','store')->name('store');
    Route::get('posts/{post}/edit','edit')->name('edit');
    Route::put('posts/{post}', 'update')->name('update');
    Route::delete('posts/{post}','delete')->name('delete');
    Route::get('/posts/{post}/reply','reply')->name('reply');
    Route::get('/posts/search','search')->name('search');
    Route::get('posts/likes','likes')->name('likes');
    
});

//いいねボタン
// Route::controller(Likecontroller::class)->group(function () {
//     Route::post('/like/{post}', 'like')->name('like'); // POSTリクエストに変更
//     Route::delete('/like/{post}', 'unlike')->name('unlike'); // DELETEリクエストを追加
// });

// Route::controller(Likecontroller::class)->group( function (){
//     Route::get('/like/{post}','like')->name('like');
//     Route::get('/unlike/{post}','unlike')->name('unlike');
// });

Route::post('/like', [LikeController::class, 'like'])->name('like');

//コメント追加
Route::controller(Replycontroller::class)->group( function (){
    Route::post('/reply', 'store')->name('reply.store');
    Route::post('/reply2', 'store2')->name('reply.store.external');
    Route::get('get-comments/{postId}','getComments');
});

//mypage
Route::controller(Usercontroller::class)->group( function () {
    Route::get('/user','index')->name('mypage.index');
    Route::get('/users/{user}','show')->name('users.show');
});

//フォロー機能
Route::controller(Friendcontroller::class)->group( function () {
    Route::post('/follow/{user}','follow')->name('follow');
    Route::post('/unfollow/{user}','unfollow')->name('unfollow');
});

//旅程作成
Route::get('/books/index', [ItineraryController::class, 'index'])->name('books.index');
Route::post('/books', [ItineraryController::class, 'store'])->name('books.store');
Route::get('/books/create/{itinerary}', [ItineraryController::class, 'create'])->name('books.create');
Route::put('/books/{itinerary}',[ItineraryController::class,'update']);
Route::delete('/books/{itinerary}',[ItineraryController::class,'delete']);

//スケジュール作成
Route::post('/schedules',[ScheduleController::class,'store'])->name('schedules.store');
Route::put('/schedules/{schedule}',[ScheduleController::class,'update'])->name('schedules.update');
Route::delete('/schedules/{schedule}',[ScheduleController::class,'delete'])->name('schedules.delete');

// Route::controller(Itinerarycontroller::class)->group( function () {
//     Route::get('/books/index', 'index')->name('books.index');
//     Route::post('/books/{itinerary}', 'store')->name('books.store');
//     Route::get('/books/create','create')->name('books.create');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
