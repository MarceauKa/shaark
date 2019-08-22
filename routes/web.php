<?php

use Illuminate\Support\Facades\Route;

Route::auth([
    'register' => false,
    'reset' => true,
    'verify' => false,
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('lien/ajouter', 'LinkController@create')->name('link.create');
Route::get('lien/modifier/{id}', 'LinkController@edit')->name('link.edit');
Route::get('lien/supprimer/{id}/{hash}', 'LinkController@delete')->name('link.delete');
