<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\PostController;
use App\Http\Controllers\ApiController\CommentController;
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
Route::post('/logout' , [AuthController::class , 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**post */
Route::prefix('/post')->group(function() {
    Route::get('/list' , [PostController::class , 'getPostList']);
    Route::post('/create' ,[PostController::class , 'create']);
    Route::delete('/delete/{post}' , [PostController::class , 'delete']);
    Route::get('/search', [PostController::class , 'search']);
    Route::get('/export' , [PostController::class , 'export']);
    Route::post('/import' , [PostController::class , 'import']);
    Route::get('/edit/{id}' , [PostController::class , 'edit']);
    Route::put('/update/{id}' , [PostController::class , 'update']);
    Route::get('/detail/{id}' , [PostController::class , 'getPostDetail']);
});

/**category */
Route::get('/categories' , [CategoryController::class , 'getCategory']);
Route::prefix('/category')->group(function(){
    Route::post('/create' ,[CategoryController::class , 'create']);
    Route::get('/list' , [CategoryController::class , 'getCategoryList']);
    Route::delete('/delete/{category}' , [CategoryController::class , 'delete']);
    Route::get('/export' , [CategoryController::class , 'export']);
    Route::get('/search' , [CategoryController::class , 'search']);
    Route::post('/import' , [CategoryController::class , 'import']);
    Route::put('/update/{id}' , [CategoryController::class , 'update']);
});

// comment
Route::post('comment/create' , [CommentController::class , 'create']);


