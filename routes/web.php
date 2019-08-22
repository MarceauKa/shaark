<?php

use Illuminate\Support\Facades\Route;

Route::auth([
    'register' => false,
    'reset' => true,
    'verify' => false,
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('lien/ajouter', 'LinkController@create')->name('link.create');
