<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'LoginController@form')->name('login');
Route::post('login', 'LoginController@check')->name('login.check');
Route::get('login/secure/{secure}', 'SecureLoginController@form')->name('login.secure');
Route::post('login/secure/{secure}', 'SecureLoginController@check')->name('login.secure.check');
Route::post('logout', 'LoginController@logout')->name('logout');

Route::get('/', 'BrowseController@index')->name('home');
Route::get('tag/{tag}', 'BrowseController@tag')->name('tag');
Route::get('shared/{id}/{token}', 'ShareController@view')->name('share');

Route::get('feed/{type}', 'FeedController@index')->name('feed');

Route::get('link/create', 'LinkController@create')->name('link.create');
Route::get('link/{id}/edit', 'LinkController@edit')->name('link.edit');
Route::get('link/archive/{id}/download', 'LinkArchiveController@download')->name('link.archive.download');

Route::get('story/create', 'StoryController@create')->name('story.create');
Route::get('story/{id}/edit', 'StoryController@edit')->name('story.edit');

Route::get('chest/create', 'ChestController@create')->name('chest.create');
Route::get('chest/{id}/edit', 'ChestController@edit')->name('chest.edit');

Route::get('album/create', 'AlbumController@create')->name('album.create');
Route::get('album/{id}/edit', 'AlbumController@edit')->name('album.edit');

Route::get('link/{link}', 'BrowseController@link')->name('link.view');
Route::get('story/{story}', 'BrowseController@story')->name('story.view');
Route::get('chest/{chest}', 'BrowseController@chest')->name('chest.view');
Route::get('album/{album}', 'BrowseController@album')->name('album.view');

Route::get('account', 'AccountController@form')->name('account');
Route::post('account', 'AccountController@store');
Route::get('account/password', 'AccountController@formPassword')->name('account.password');
Route::post('account/password', 'AccountController@storePassword');
Route::get('account/logins', 'AccountController@viewLogins')->name('account.logins');
Route::post('account/logins/logout', 'AccountController@logoutDevices')->name('account.logins.logout');

Route::get('manifest.json', 'PwaController@manifest')->name('pwa.manifest');
Route::get('sw.js', 'PwaController@worker')->name('pwa.worker');
Route::get('offline', 'PwaController@offline')->name('pwa.offline');

Route::group([
    'as' => 'manage.',
    'prefix' => 'manage',
    'middleware' => ['auth', 'manage'],
    'namespace' => 'Manage',
], function (\Illuminate\Routing\Router $router) {
    $router->get('import', 'ImportController@form')->name('import');
    $router->post('import', 'ImportController@import');
    $router->get('export', 'ExportController@form')->name('export');
    $router->post('export', 'ExportController@export');
    $router->get('users', 'UsersController@all')->name('users');
    $router->get('tags', 'TagsController@view')->name('tags');
    $router->get('archives', 'ArchivesController@view')->name('archives');
    $router->get('settings', 'SettingsController@form')->name('settings');
    $router->post('settings', 'SettingsController@store');
});

