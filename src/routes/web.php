<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosMainController;

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


Route::group(['middleware' => ['web','auth']], function() {
    Route::get('/', [VideosMainController::class,'index'])->name('videos.uploadVideo');

    Route::get('createvideo', [VideosMainController::class,'createVideo'])->name('videos.createVideo');

    Route::post('uploadvideo', [VideosMainController::class,'uploadVideo'])->name('videos.uploadVideo');
});