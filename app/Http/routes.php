<?php

// List
Route::get('list/get', 'ListController@index');
Route::get('list/get/{id}', 'ListController@detail');
Route::post('list/add', 'ListController@add');
Route::post('list/update', 'ListController@update');
Route::get('list/remove', 'ListController@remove'); // todo

// User
// todo
//Route::login('login', 'Auth\AuthController@login');
Route::get('login', 'UserController@login');
Route::post('register','UserController@register');