<?php

Route::get('/', [
	'as'   => 'home',
	'uses' => 'HomeController@index'
]);

Route::group(['prefix' => 'site'], function  () {
    Route::get('create/{id}', [
        'as'   => 'site.create',
        'uses' => 'SiteController@create'
    ]);

    Route::post('create/{id}', [
        'as'   => 'site.create',
        'uses' => 'SiteController@store'
    ]);
    Route::get('edit/{id}', [
        'as'   => 'site.edit',
        'uses' => 'SiteController@edit'
    ]);

    Route::post('edit/{id}', [
        'as'   => 'site.edit',
        'uses' => 'SiteController@update'
    ]);

    Route::get('delete/{id}', [
        'as'   => 'site.delete',
        'uses' => 'SiteController@destroy'
    ]);
});

Route::group(['prefix' => 'group'], function  () {
    Route::get('create', [
        'as'   => 'group.create',
        'uses' => 'GroupController@create'
    ]);

    Route::post('create', [
        'as'   => 'group.create',
        'uses' => 'GroupController@store'
    ]);

    Route::get('edit/{id}', [
        'as'   => 'group.edit',
        'uses' => 'GroupController@edit'
    ]);

    Route::post('edit/{id}', [
        'as'   => 'group.edit',
        'uses' => 'GroupController@update'
    ]);

    Route::get('delete/{id}', [
        'as'   => 'group.delete',
        'uses' => 'GroupController@destroy'
    ]);

    Route::get('/{id}', [
        'as'   => 'group.show',
        'uses' => 'GroupController@show'
    ]);

    Route::get('/', [
        'as'   => 'group.index',
        'uses' => 'GroupController@index'
    ]);
});

Route::group(['prefix' => 'directory'], function  () {
    Route::get('lookup', [
        'as'   => 'directory.lookup',
        'uses' => 'DirectoryController@lookup'
    ]);
});
