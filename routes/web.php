<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SelectionController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// submit mood form
Route::post('/submit-selection', [SelectionController::class, 'submitForm'])->name('submit.selection');
