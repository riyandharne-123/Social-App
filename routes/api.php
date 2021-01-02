<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login','Api\UserController@login')->name('login');
Route::post('/register','Api\UserController@register')->name('register');

Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api'],function(){
    Route::get('/verify_user','UserController@verify');
    Route::get('/logged_user','UserController@logged_user');
    Route::get('/user','UserController@get_current_user');
    Route::resource('users','UserController');
    Route::resource('following','FollowingController');
    Route::resource('posts','PostController');
    Route::resource('likes','LikeController');
    Route::resource('comments','CommentController');
    Route::resource('user_posts','UserPostController');
    Route::post('removelike','LikeController@delete');
    Route::post('unfollow','FollowingController@delete'); 
});
