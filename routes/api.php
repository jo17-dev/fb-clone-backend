<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DiscutionController;

// session_start();
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// friendship management (via ajax): search, invite user 
Route::post('/friendship', [FriendshipController::class, 'search_users']);
Route::get('/friendship/{reveiverId}/{senderId}', [FriendshipController::class, 'invite_user']);
Route::delete('/friendship/{id}/{currentUser}', [FriendshipController::class, 'destroy']);

// post likes management
Route::post('/likes', [LikeController::class, 'likes_number']);
Route::get('/likes', [LikeController::class, 'like_post']);

// Comment like management
Route::get('/likescomment', [LikeController::class, 'like_comment']);

// user block/unblock
Route::post('/discution', [DiscutionController::class, 'toggleBlock']);