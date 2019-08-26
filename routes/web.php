<?php

use Illuminate\Support\Facades\Route;

Route::auth([
    'register' => false,
    'reset' => true,
    'verify' => false,
]);

Route::feeds();

Route::get('/', 'BrowseController@index')->name('home');
Route::get('/tag/{tag}', 'BrowseController@tag')->name('tag');

Route::get('link/create', 'LinkController@create')->name('link.create');
Route::get('link/edit/{id}', 'LinkController@edit')->name('link.edit');
Route::get('link/refresh/{id}/{hash}', 'LinkController@refresh')->name('link.refresh');
Route::get('link/delete/{id}/{hash}', 'LinkController@delete')->name('link.delete');

Route::get('story/create', 'StoryController@create')->name('story.create');
Route::get('story/edit/{id}', 'StoryController@edit')->name('story.edit');
Route::get('story/delete/{id}/{hash}', 'StoryController@delete')->name('story.delete');

Route::get('link/{link}', 'BrowseController@link')->name('link.view');
Route::get('story/{story}', 'BrowseController@story')->name('story.view');

Route::get('account', 'AccountController@form')->name('account');
Route::post('account', 'AccountController@store');
Route::post('account/password', 'AccountController@storePassword')->name('account.password');
Route::get('import', 'ImportController@form')->name('import');
Route::post('import', 'ImportController@store');
