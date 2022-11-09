<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\PostController;
use App\Http\Controllers\ApiController\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register' , [AuthController::class , 'register']);
Route::post('/login' , [AuthController::class , 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/post')->group(function() {
    Route::get('/list' , [PostController::class , 'getPostList']);
    Route::post('/create' ,[PostController::class , 'create']);
    Route::delete('/delete/{id}' , [PostController::class , 'delete']);
    Route::get('/search', [PostController::class , 'search']);
    Route::get('/export' , [PostController::class , 'export']);
});

Route::post('/category/create' ,[CategoryController::class , 'create']);
Route::get('/category/list' , [CategoryController::class , 'getCategoryList']);
Route::delete('/category/delete/{id}' , [CategoryController::class , 'delete']);
Route::get('/categories' , [CategoryController::class , 'getCategory']);
Route::get('category/export' , [CategoryController::class , 'export']);
Route::get('category/search' , [CategoryController::class , 'search']);

