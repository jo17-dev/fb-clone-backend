<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscutionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessageController;
use App\Http\Controllers\GroupMembershipController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendshipController;
use App\Models\Post;
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

// page d'accuiel:
Route::get('/', function(){
    return redirect('/home');
});

// user resources
Route::resource('/home', UserController::class);
Route::get('/disconnect', function(){
    Session::forget('user_session_data');
    return redirect('/home', 302);
});

// my account
Route::get('/dashboard/myaccount/edit', function(){
    return view('acceuil.update');
});

// Dashboard
Route::resource('/dashboard', PostController::class);

// reply form, store or delete a reply
Route::get('/dashboard/post/comment/{id_comment}', [CommentController::class, 'reply_form']);
Route::post('/dashboard/post/comment/{id_comment}', [CommentController::class, 'store']);

// store a comment, delete a comment/reply
Route::post('/dashboard/{id_post}/comment/', [CommentController::class, 'store']);
Route::delete('/dashboard/{id_post}/comment', [CommentController::class, 'destroy']);

// discutions management:
Route::resource('/discution', DiscutionController::class);

Route::post('/discution/{id}', [MessageController::class, 'store']); // store an message on a discution
Route::delete('/discution/{id_message}/delete', [MessageController::class, 'destroy']); // this called only by

// noitifications center
Route::get('/notification', [NotificationController::class, 'index']);
Route::get('/notification/friendship', [FriendshipController::class, 'accept_or_reject_friendship_invitation']); // this route is for accept or reject an friendship
Route::delete('/notification', [NotificationController::class, 'destroy']);

// groups management
Route::resource('/group', GroupController::class);
Route::post('/group/{id}', [GroupMessageController::class, 'store']); // store an message on a group
Route::delete('/group/{id_message}/delete', [GroupMessageController::class, 'destroy']); // this called only by
//memberships
Route::post('/group/{id}/edit', [GroupMembershipController::class, 'add_member']); // add member by admin
Route::get('/group/{id}/parameters', [GroupController::class, 'show_group_info']);
Route::post('/group/{id}/removeMember', [GroupMembershipController::class, 'remove_member']);


