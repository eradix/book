<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//routes with custom middleware (using authorization)
// Route::group(['middleware' => 'verified_token', 'prefix' => 'v2'], function () {
//     Route::resource('/books', BooksController::class);
// });

//private routes
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v2'], function () {
    Route::resource('/books', BooksController::class);
    Route::get('books/search/{searchString}', [BooksController::class, 'search']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//public routes
Route::group(['prefix' => 'v2'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'store']);
});