<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'LoginController@form')->name('login');
Route::post('login', 'LoginController@check')->name('login.check');
Route::get('login/secure/{secure}', 'SecureLoginController@form')->name('login.secure');
Route::post('login/secure/{secure}', 'SecureLoginController@check')->name('login.secure.check');
Route::post('logout', 'LoginController@logout')->name('logout');

Route::get('/', 'BrowseController@index')->name('home');
Route::get('/tag/{tag}', 'BrowseController@tag')->name('tag');

Route::get('link/create', 'LinkController@create')->name('link.create');
Route::get('link/edit/{id}', 'LinkController@edit')->name('link.edit');

Route::get('link/archive/{id}', 'LinkArchiveController@form')->name('link.archive.form');
Route::post('link/archive/{id}', 'LinkArchiveController@store');
Route::post('link/archive/{id}/delete', 'LinkArchiveController@delete')->name('link.archive.delete');
Route::get('link/archive/{id}/download/{hash}', 'LinkArchiveController@download')->name('link.archive.download');

Route::get('story/create', 'StoryController@create')->name('story.create');
Route::get('story/{id}/edit', 'StoryController@edit')->name('story.edit');

Route::get('chest/create', 'ChestController@create')->name('chest.create');
Route::get('chest/{id}/edit', 'ChestController@edit')->name('chest.edit');

Route::get('link/{link}', 'BrowseController@link')->name('link.view');
Route::get('story/{story}', 'BrowseController@story')->name('story.view');
Route::get('chest/{chest}', 'BrowseController@chest')->name('chest.view');

Route::get('account', 'AccountController@form')->name('account');
Route::post('account', 'AccountController@store');
Route::get('account/password', 'AccountController@formPassword')->name('account.password');
Route::post('account/password', 'AccountController@storePassword');
Route::get('account/logins', 'AccountController@viewLogins')->name('account.logins');
Route::post('account/logins/logout', 'AccountController@logoutDevices')->name('account.logins.logout');

Route::get('manage/import', 'Manage\ImportController@form')->name('manage.import');
Route::post('manage/import', 'Manage\ImportController@import');
Route::get('manage/export', 'Manage\ExportController@form')->name('manage.export');
Route::post('manage/export', 'Manage\ExportController@export');
Route::get('manage/tags', 'Manage\TagsController@view')->name('manage.tags');
Route::get('manage/settings', 'Manage\SettingsController@form')->name('manage.settings');
Route::post('manage/settings', 'Manage\SettingsController@store');

