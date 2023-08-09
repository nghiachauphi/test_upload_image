<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*
|--------------------------------------------------------------------------
| Web LOGIN
|--------------------------------------------------------------------------
|
|
*/
Route::get('/google_login', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('google_login');
Route::get('/google_login_callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

//Route::get('/user/{id}', [App\Http\Controllers\UserViewController::class, 'getImage'])->name('add_avatar');
//Route::post('/user/{id}', [App\Http\Controllers\UserViewController::class, 'postImage']);

//get server user
//Route::get('/user', [App\Http\Controllers\UserViewController::class, 'index'])->name('user');
//Route::post('/login', [App\Http\Controllers\UserViewController::class, 'postlogin'])->name('postlogin');

/*
|--------------------------------------------------------------------------
| Web POST
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('visitor')->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('/sunflower-mission', [App\Http\Controllers\HomeController::class, 'test'])->name('lythukhoa');
    Route::get('/van-anh', [App\Http\Controllers\HomeController::class, 'test'])->name('lythukhoa');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/', [App\Http\Controllers\HomeController::class, 'ContactInfo'])->name('contact');
    Route::get('/stop_gif', [App\Http\Controllers\HomeController::class, 'stopGif'])->name('stop_gif');

    Route::post('/login', [App\Http\Controllers\UserViewController::class, 'login_local'])->name('login_local');

    Route::get('/report', [App\Http\Controllers\PostImageViewController::class, 'getReport'])->name('report');

    Route::get('/free_image', [App\Http\Controllers\PostImageViewController::class, 'getImage'])->name('free_image');
    Route::get('/free_image/{id}', [App\Http\Controllers\PostImageViewController::class, 'show']);

    Route::get('/free_image_multipart', [App\Http\Controllers\PostImageViewController::class, 'getImageMultipart'])->name('free_image_multipart');
    Route::get('/free_image_multipart/{id}', [App\Http\Controllers\PostImageViewController::class, 'getGoogleDriveImage']);

    Route::get('/upload_file', [App\Http\Controllers\PostImageViewController::class, 'ggdrive'])->name('free_video');
    Route::get('/upload_file/{id}', [App\Http\Controllers\PostImageViewController::class, 'showGGDrive']);

    Route::post('/upload_file_multipart', [App\Http\Controllers\PostImageViewController::class, 'postFileMultipart'])->name('post_free_file');
    Route::get('/upload_file_multipart', [App\Http\Controllers\PostImageViewController::class, 'getFileMultipart'])->name('free_file');
    Route::get('/upload_file_multipart/{id}', [App\Http\Controllers\PostImageViewController::class, 'showFileMultipart']);

    //get local
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [App\Http\Controllers\UserViewController::class, 'index_local'])->name('user');
        Route::get('/user/history', [App\Http\Controllers\UserViewController::class, 'historyUpload'])->name('history_upload');

        Route::get('/category', [App\Http\Controllers\CategoryViewController::class, 'index']);
        Route::get('/category/create', [App\Http\Controllers\CategoryViewController::class, 'create']);
        Route::get('/category/export', [App\Http\Controllers\CategoryViewController::class, 'exportExcel'])->name('category.export');
        Route::post('/category/import', [App\Http\Controllers\CategoryViewController::class, 'importExcel'])->name('category.import');

        Route::get('/visitor/view', [App\Http\Controllers\VisitorController::class, 'logRequest'])->name('report_view');
    });
});

