<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/', [FileController::class, 'upload']);
Route::get('/file/{name}', [FileController::class, 'download']);
Route::get('/delete/{name}', [FileController::class, 'delete']);

