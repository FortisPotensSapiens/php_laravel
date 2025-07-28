<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return response()->json([
        'POST /' => 'Upload file (form-data key: file)',
        'GET /file/{name}' => 'Download file by generated name',
        'DELETE /delete/{name}' => 'Delete file prematurely'
    ]);
});

Route::post('/', [FileController::class, 'upload']);
Route::get('/file/{name}', [FileController::class, 'download']);
Route::delete('/delete/{name}', [FileController::class, 'delete']);

// Route::get('/', function () {
//     return view('welcome');
// });