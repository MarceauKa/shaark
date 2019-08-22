<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('search', 'SearchController@search')->name('search');

Route::post('link/parse', 'LinkController@parse')->name('link.parse');
Route::post('link', 'LinkController@store')->name('link.store');
