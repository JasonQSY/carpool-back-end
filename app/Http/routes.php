<?php

Route::get('list/get', 'ListController@index');
Route::get('list/get/{id}', 'ListController@detail');
Route::get('user/login', 'UserController@login');
Route::post('list/add', 'ListController@add');


Route::group(['middleware' => ['web']], function()
{
    //Route::post('list/add', 'ListController@add');
    Route::post('list/update', 'ListController@creatorUpdate');
    Route::get('list/drop', 'ListController@peopleDropout');
    Route::get('user/profile', 'UserController@profile');
});
