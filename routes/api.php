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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group([
    'middleware' => 'auth:api'
  ], function() {
      Route::get('post/user', 'PostsController@userPosts');
      Route::post('post/vote', 'PostsController@votePost');
      Route::resource('post', 'PostsController');
      Route::get('challenge/current_challenge', 'ChallengesController@currentChallenge');
      Route::get('challenge/leaderBoard', 'ChallengesController@leaderBoard');
      Route::resource('challenge', 'ChallengesController');
      Route::get('daily_mission/get_calendar', 'DailyMissionController@get_calendar');
      Route::get('daily_mission/get_challenge_by_date', 'DailyMissionController@get_challenge_by_date');
      Route::get('daily_mission/next_challenges', 'DailyMissionController@next_challenges');
  });