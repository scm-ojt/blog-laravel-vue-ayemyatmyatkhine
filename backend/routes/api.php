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

Route::post('/post/create' ,[PostController::class , 'create']);
Route::get('/post/list' , [PostController::class , 'getPostList']);
Route::delete('/post/delete/{$id}' , [PostController::class , 'delete']);
Route::post('/category/create' ,[CategoryController::class , 'create']);
Route::get('/category/list' , [CategoryController::class , 'getCategoryList']);
Route::delete('/category/delete/{$id}' , [CategoryController::class , 'delete']);
