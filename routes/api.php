<?php

use App\Http\Controllers\SingerController;
use App\Http\Controllers\SongController;
use App\Models\Song;
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
Route::resource('songs', SongController::class);
Route::resource('singers', SingerController::class);
Route::get('/search/{q?}', [SongController::class, 'search']);
Route::get('favorite', [SongController::class, 'searchByIds']);
Route::get('recently', [SongController::class, 'getRecentlySongs']);
Route::get('reccommed', [SongController::class, 'getReccommedSongs']);
Route::get('next', [SongController::class, 'getNextSong']);
