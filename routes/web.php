<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'LoginController@form')->name('login');
Route::post('login', 'LoginController@check')->name('login.check');
Route::get('login/secure/{token}', 'SecureLoginForm@form')->name('login.secure');
Route::post('login/secure/{token}', 'SecureLoginForm@check')->name('login.secure.check');
Route::post('logout', 'LoginController@logout')->name('logout');

Route::get('/', 'BrowseController@index')->name('home');
Route::get('/tag/{tag}', 'BrowseController@tag')->name('tag');

Route::get('link/create', 'LinkController@create')->name('link.create');
Route::get('link/edit/{id}', 'LinkController@edit')->name('link.edit');
Route::get('link/delete/{id}/{hash}', 'LinkController@delete')->name('link.delete');
Route::get('link/update-preview/{id}/{hash}', 'LinkActionsController@updatePreview')->name('link.update-preview');
Route::get('link/archive/{id}', 'LinkActionsController@archiveForm')->name('link.archive-form');
Route::post('link/archive/{id}', 'LinkActionsController@archiveStore');
Route::post('link/delete-archive/{id}', 'LinkActionsController@archiveDelete')->name('link.archive-delete');
Route::get('link/download-archive/{id}/{hash}', 'LinkActionsController@archiveDownload')->name('link.archive-download');

Route::get('story/create', 'StoryController@create')->name('story.create');
Route::get('story/edit/{id}', 'StoryController@edit')->name('story.edit');
Route::get('story/delete/{id}/{hash}', 'StoryController@delete')->name('story.delete');

Route::get('chest/create', 'ChestController@create')->name('chest.create');
Route::get('chest/edit/{id}', 'ChestController@edit')->name('chest.edit');
Route::get('chest/delete/{id}/{hash}', 'ChestController@delete')->name('chest.delete');

Route::get('link/{link}', 'BrowseController@link')->name('link.view');
Route::get('story/{story}', 'BrowseController@story')->name('story.view');
Route::get('chest/{chest}', 'BrowseController@chest')->name('chest.view');

Route::get('account', 'AccountController@form')->name('account');
Route::post('account', 'AccountController@store');
Route::post('account/password', 'AccountController@storePassword')->name('account.password');

Route::get('manage/import', 'ManageController@importForm')->name('manage.import');
Route::post('manage/import', 'ManageController@importStore');
Route::get('manage/export', 'ManageController@exportForm')->name('manage.export');
Route::post('manage/export', 'ManageController@export');
Route::get('manage/tags', 'ManageController@tags')->name('manage.tags');
Route::get('manage/tags/delete/{tag}/{hash}', 'ManageController@deleteTag')->name('manage.tags.delete');
Route::get('manage/settings', 'ManageController@settingsForm')->name('manage.settings');
Route::post('manage/settings', 'ManageController@settingsStore');
