<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 TODO: Version 2 clean up endpoints -  Reccos/Boards may want to prefix users /users/{id}.
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('v1/phone/exchange/access_code', 'PhoneController@exchangeAccessCode');
Route::post('v1/phone/verify/access_code', 'PhoneController@verifyAccessCode');
Route::post('v1/authenticate/facebook', 'AuthController@facebook');

// Users / User Feed
Route::apiResource('v1/users', 'UserController');
Route::get('v1/users/{user}/feed', 'UserController@feed');
Route::get('v1/users/{user}/feed/recco/{recco}', 'UserController@recco');
Route::get('v1/users/{user}/profile', 'UserController@profile');

// Hidden users
Route::get('v1/users/{user}/block', 'BlockUserController@index');
Route::post('v1/users/{user}/block', 'BlockUserController@add');
Route::delete('v1/users/{user}/block', 'BlockUserController@delete');

// Achievements
Route::get('v1/users/{user}/achievements', 'UserController@achievements');

// Social Media Sharing
Route::post('v1/users/{user}/share/facebook', 'ShareController@facebook');
Route::post('v1/users/{user}/share/twitter', 'ShareController@twitter');

// Notification
Route::get('v1/users/{user}/notifications', 'UserNotificationController@index');
Route::patch('v1/users/{user}/notifications/{notification}', 'UserNotificationController@update');
Route::delete('v1/users/{user}/notifications/{notification}', 'UserNotificationController@delete');

// Flag
Route::apiResource('v1/reccos', 'ReccoController');
Route::post('v1/reccos/{recco}/flag', 'FlagReccoController@flag');

// Boards
Route::apiResource('v1/boards', 'BoardController'); // TODO: Update to Users/{id}/boards
Route::get('v1/users/{user}/boards/{boardId}/reccos', 'BoardController@reccos');
Route::post('v1/boards/{board}/pin', 'BoardController@pin'); // TODO: Update to Users/{id}/boards

Route::delete('v1/boards/{board}/pin/{recco}', 'BoardController@unpin'); // TODO: Update to Users/{id}/boards
Route::apiResource('v1/comments', 'CommentController');
Route::apiResource('v1/ratings', 'RatingController');

Route::post('v1/photo/pre-signed-url', 'PhotoController@presignUrl');


// Prompts
Route::get('v1/prompts/random', 'PromptController@random');
Route::apiResource('v1/prompts', 'PromptController', [
    'only' => ['index', 'show']
]);

// Deprecated
Route::post('v1/users/{user}/hide', 'BlockUserController@block'); // deprecated
Route::post('v1/users/{user}/unhide', 'BlockUserController@unblock'); // deprecated
Route::apiResource('v1/categories', 'CategoryController', [
    'only' => 'index'
]);