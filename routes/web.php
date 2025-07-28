<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', [FileController::class, 'index']);
Route::post('/', [FileController::class, 'upload']);
Route::get('/file/{generated_name}', [FileController::class, 'download']);
Route::get('/delete/{generated_name}', [FileController::class, 'delete']);
