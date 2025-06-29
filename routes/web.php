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

// view data
Route::get('/home', [SelectionController::class, 'viewSelections'])->name('view.selections');


// edit data
Route::get('/selection/{id}/edit', [SelectionController::class, 'edit'])->name('selection.edit');
Route::put('/selection/{id}', [SelectionController::class, 'update'])->name('selection.update');


// de;ete

Route::delete('/selection/{id}', [SelectionController::class, 'destroy'])->name('selection.delete');