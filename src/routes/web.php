<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\AuthController;

// 公開ページ
Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::get('/thanks', [ContactController::class, 'thanks']);

// 認証
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');   // ← これを呼ぶ
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');  // ← フォームのPOST先
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 管理画面（要ログイン）— 二重定義をやめ、auth で保護
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminContactController::class, 'index'])->name('admin.index');
    Route::get('/admin/export', [AdminContactController::class, 'export'])->name('admin.export');
    Route::delete('/admin/{contact}', [AdminContactController::class, 'destroy'])->name('admin.destroy');
});
