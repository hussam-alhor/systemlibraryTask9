<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;

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

// Route::post('/books' , [BookController::class , 'store'])->middleware('Admin_Meddleware');
// Route::get('/books' , [BookController::class , 'index']);
// Route::get('/books/{id}' , [BookController::class , 'show']);
// Route::put('/books/{id}' , [BookController::class , 'update'])->middleware('Admin_Meddleware');
// Route::delete('/books/{id}' , [BookController::class , 'destroy'])->middleware('Admin_Meddleware');


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    
});

Route::get('/user/profile' , [AuthController::class , 'getProfile']);


Route::middleware('auth:api')->group(function () {
    Route::post('/books', 'BookController@store')->middleware('Admin_Meddleware');
    Route::get('/books', 'BookController@index');
    Route::get('/books/{id}', 'BookController@show');
    Route::put('/books/{id}', 'BookController@update')->middleware('Admin_Meddleware');
    Route::delete('/books/{id}', 'BookController@destroy')->middleware('Admin_Meddleware');
});



// Add a new author (admin only)
Route::post('/authors', [AuthorController::class, 'store'])->middleware('Admin_Meddleware');

// List all authors
Route::get('/authors', [AuthorController::class, 'index']);

// Get detailed information about a specific author
Route::get('/authors/{id}', [AuthorController::class, 'show']);

// Update author information (admin only)
Route::put('/authors/{id}', [AuthorController::class, 'update'])->middleware('Admin_Meddleware');

// Delete an author (admin only)
Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->middleware('Admin_Meddleware');