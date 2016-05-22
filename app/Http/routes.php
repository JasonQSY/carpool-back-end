<?php

// List
Route::group(['middleware' => ['web']], function()
{
    Route::get('list/get', 'ListController@index');
    Route::get('list/get/{id}', 'ListController@detail');
    Route::post('list/add', 'ListController@add');
    Route::post('list/update', 'ListController@update'); //todo
    Route::get('list/remove/{id}', 'ListController@remove');
});
// User
// todo
//Route::login('login', 'Auth\AuthController@login');
Route::get('login', 'UserController@login');
Route::post('register','UserController@register');
Route::post('user/authToken', 'UserController@authToken');  //need access_token and openid
Route::get('user/getCodeUrl', 'UserController@getCodeUrl');
Route::get('user/getAccessToken', 'UserController@getAccessToken');
