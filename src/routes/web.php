<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//商品一覧関連//
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/search',[ItemController::class,'search'])->name('item.search');
Route::get('/item/{item}',[ItemController::class,'show'])->name('item.detail');

//認証・管理関連//
//未ログインユーザー
Route::get('/email/verify', function (){
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}',function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.index');
})->middleware(['auth','signed'])->name('verification.verify');

//認証メール再送//
Route::post('/email/verification-notification', function (Request $request){
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message','認証メールを再送しました');
})->middleware(['auth','throttle:6,1'])->name('verification.send');


Route::middleware(['auth','verified'])->group(function(){
    //出品
    Route::get('/sell',[ItemController::class,'create'])->name('item.create');
    Route::post('/sell',[ItemController::class,'store'])->name('item.store');

    //マイリスト
    Route::get('/mylist',[ItemController::class,'mylist'])->name('item.mylist');

    //プロフィール関連
    Route::get('/mypage',[ProfileController::class,'index'])->name('profile.index');
    Route::get('/mypage/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::post('/mypage/profile',[ProfileController::class,'update'])->name('profile.update');

    //いいね関連
    Route::post('/item/{item}/like',[LikeController::class,'store'])->name('item.like');
    Route::delete('/item/{item}/like',[LikeController::class,'destroy'])->name('item.unlike');

    //コメント
    Route::post('/item/{item}/comment',[CommentController::class,'store'])->name('item.comment');

    //購入
    Route::get('/purchase/{item}',[PurchaseController::class,'create'])->name('purchase.create');
    Route::post('/purchase/{item}',[PurchaseController::class,'store'])->name('purchase.store');

    //住所変更
    Route::get('/purchase/address/{item}',[PurchaseController::class,'editAddress'])->name('purchase.address');
    Route::post('/purchase/address/{item}',[PurchaseController::class,'updateAddress'])->name('purchase.address.update');

});
