<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/book-page', \App\Livewire\BookPage::class)->name('book-page');
Route::get('/borrow-page', \App\Livewire\BorrowPage::class)->name('borrow-page');
Route::get('/member-page', \App\Livewire\MemberPage::class)->name('member-page');
