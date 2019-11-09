<?php

use Illuminate\Support\Facades\Route;

Route::post('search', 'SearchController@search')->name('search');

Route::get('tags', 'TagsController@all')->name('tags');

Route::post('account/logins/purge', 'AccountController@purge')->name('account.logins.purge');

Route::post('link/parse', 'LinkController@parse')->name('link.parse');
Route::post('link', 'LinkController@store')->name('link.store');
Route::put('link/{id}', 'LinkController@update')->name('link.update');
Route::delete('link/{id}', 'LinkController@delete')->name('link.delete');

Route::get('link/{id}/archive', 'LinkArchiveController@get')->name('link.archive');
Route::put('link/{id}/archive', 'LinkArchiveController@store');
Route::delete('link/{id}/archive', 'LinkArchiveController@delete');

Route::post('story', 'StoryController@store')->name('story.store');
Route::put('story/{id}', 'StoryController@update')->name('story.update');
Route::delete('story/{id}', 'StoryController@delete')->name('story.delete');

Route::post('chest', 'ChestController@store')->name('chest.store');
Route::put('chest/{id}', 'ChestController@update')->name('chest.update');
Route::delete('chest/{id}', 'ChestController@delete')->name('chest.delete');

Route::post('album', 'AlbumController@store')->name('album.store');
Route::post('album/upload', 'AlbumController@upload')->name('album.image.upload');
Route::put('album/{id}', 'AlbumController@update')->name('album.update');
Route::delete('album/{id}', 'AlbumController@delete')->name('album.delete');

Route::get('share/{post_id}', 'ShareController@get')->name('share');
Route::post('share/{post_id}', 'ShareController@store');

Route::group([
    'as' => 'manage.',
    'prefix' => 'manage',
    'middleware' => ['auth:api', 'manage'],
    'namespace' => 'Manage',
], function (\Illuminate\Routing\Router $router) {
    $router->get('tags', 'TagsController@all')->name('tags.all');
    $router->delete('tags/{tag}', 'TagsController@delete')->name('tags.delete');
    $router->post('tags/{from}/move/{to}', 'TagsController@move')->name('tags.move');

    $router->get('archives', 'ArchivesController@all')->name('archives');

    $router->get('features/{type}', 'FeaturesController@check');

    $router->get('users', 'UsersController@all')->name('users.all');
    $router->post('users', 'UsersController@store')->name('users.store');
    $router->get('users/{id}', 'UsersController@get')->name('users.get');
    $router->put('users/{id}', 'UsersController@update')->name('users.update');
    $router->delete('users/{id}', 'UsersController@delete')->name('users.delete');
});
