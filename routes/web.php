<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CnnController;

Route::get('/', [CnnController::class, 'index'])->name('home');
Route::get('/predict', [CnnController::class, 'predict'])->name('predict');
Route::post('/predict', [CnnController::class, 'try_predict'])->name('try_predict');
Route::get('/about', [CnnController::class, 'about'])->name('about');