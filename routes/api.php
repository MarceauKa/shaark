<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('search', 'SearchController@search')->name('search');

Route::get('tags', 'TagsController@all')->name('tags');

Route::post('link/parse', 'LinkController@parse')->name('link.parse');
Route::post('link', 'LinkController@store')->name('link.store');
Route::put('link/{id}', 'LinkController@update')->name('link.update');

Route::post('story', 'StoryController@store')->name('story.store');
Route::put('story/{id}', 'StoryController@update')->name('story.update');

Route::post('chest', 'ChestController@store')->name('chest.store');
Route::put('chest/{id}', 'ChestController@update')->name('chest.update');
