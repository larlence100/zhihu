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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $topics = \App\Topic::select(['id','name'])->where('name','like','%'.$request->query('q').'%')->get();
    return $topics;
});

/*Route::middleware('api')->post('/question/follower', function (Request $request) {
    return $request->all();
});*/

Route::post('/question/follower','QuestionFollowController@follower')->middleware('auth:api');
Route::post('/question/follow','QuestionFollowController@followThisQuestion')->middleware('auth:api');


Route::get('/user/followers/{user}','FollowersController@followers')->middleware('auth:api');
Route::post('/user/follow','FollowersController@follow')->middleware('auth:api');



Route::get('/answer/{answer}/vote/users','VotesController@users')->middleware('auth:api');
Route::Post('/answer/vote','VotesController@vote')->middleware('auth:api');

Route::post('/message/store', 'MessageController@store')->middleware('auth:api');

Route::get('/answer/{id}/comments','CommentsController@answer')->middleware('auth:api');
Route::get('/question/{id}/comments','CommentsController@question')->middleware('auth:api');
Route::post('/comment', 'CommentsController@store')->middleware('auth:api');