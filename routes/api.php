<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
Route::post('/user/create', [App\Http\Controllers\UserController::class, 'create']);

Route::get('/visitor/report', [App\Http\Controllers\VisitorController::class, 'index']);
Route::get('/visitor/log', [App\Http\Controllers\VisitorController::class, 'logRequestAPI']);

Route::get('/free_image/report', [App\Http\Controllers\PostImageController::class, 'getReportBase64']);
Route::get('/upload_file/report', [App\Http\Controllers\PostImageController::class, 'getReportGGDrive']);

Route::get('/free_image/{id}', [App\Http\Controllers\PostImageController::class, 'index']);
Route::post('/free_image', [App\Http\Controllers\PostImageController::class, 'create']);

Route::get('/free_image_multipart/{id}', [App\Http\Controllers\PostImageController::class, 'getGoogleDriveImage']);
Route::post('/free_image_multipart', [App\Http\Controllers\PostImageController::class, 'upGoogleDriveImage']);

Route::get('/upload_file/{id}', [App\Http\Controllers\PostImageController::class, 'getGoogleDrive']);
Route::post('/upload_file', [App\Http\Controllers\PostImageController::class, 'upGoogleDrive']);

Route::post('/upload_file_multipart', [App\Http\Controllers\PostImageController::class, 'upGoogleDriveFile']);
Route::get('/upload_file_multipart/{id}', [App\Http\Controllers\PostImageController::class, 'getGoogleDriveFile']);

Route::get('/countdown', [App\Http\Controllers\HomeController::class, 'CountDownDate']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
//    Route::get('/user/all', function (Request $request) {
//        return \App\Models\User::all();
//    });
    Route::post('/change_password', [App\Http\Controllers\UserController::class, 'change_password']);
    Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update']);
    Route::post('/user/delete/', [App\Http\Controllers\UserController::class, 'delete']);
    Route::get('/user/image', [App\Http\Controllers\UserController::class, 'getImage']);
    Route::post('/user/image', [App\Http\Controllers\UserController::class, 'postImage']);

    Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/category/create', [App\Http\Controllers\CategoryController::class, 'create']);
    Route::post('/category/update', [App\Http\Controllers\CategoryController::class, 'update']);
    Route::post('/category/delete', [App\Http\Controllers\CategoryController::class, 'delete']);
    Route::post('/category/import', [App\Http\Controllers\CategoryController::class, 'importExcel']);

    Route::get('/user/image/', [App\Http\Controllers\UserUpload::class, 'getBase64']);
    Route::get('/user/file/', [App\Http\Controllers\UserUpload::class, 'getDrive']);
});

