<?php

Route::get('/', [
    'as'         => 'home',
    'uses'       => 'HomeController@index',
    'middleware' => 'active:home'
]);

Route::group(['prefix' => 'site'], function () {
    Route::get('editor/{editor}/{id}', [
        'as'   => 'site.editor',
        'uses' => 'SiteController@editor',
    ]);

    Route::get('generate', [
        'as'         => 'site.generate',
        'uses'       => 'SiteController@generate',
        'middleware' => 'active:generate'
    ]);

    Route::post('generate', [
        'as'   => 'nginx.generate',
        'uses' => 'SiteController@storeGenerated'
    ]);
});

Route::group(['namespace' => 'Site'], function () {
    Route::group(['prefix' => 'nginx'], function () {
        Route::get('create/{id}', [
            'as'   => 'nginx.create',
            'uses' => 'NginxController@create'
        ]);

        Route::post('create/{id}', [
            'as'   => 'nginx.create',
            'uses' => 'NginxController@store'
        ]);

        Route::get('edit/{id}', [
            'as'   => 'nginx.edit',
            'uses' => 'NginxController@edit'
        ]);

        Route::post('edit/{id}', [
            'as'   => 'nginx.edit',
            'uses' => 'NginxController@update'
        ]);

        Route::get('delete/{id}', [
            'as'   => 'nginx.delete',
            'uses' => 'NginxController@destroy'
        ]);
    });

    Route::group(['prefix' => 'homestead'], function () {
        Route::get('create/{id}', [
            'as'   => 'homestead.create',
            'uses' => 'HomesteadController@create'
        ]);

        Route::post('create/{id}', [
            'as'   => 'homestead.create',
            'uses' => 'HomesteadController@store'
        ]);
        Route::get('edit/{id}', [
            'as'   => 'homestead.edit',
            'uses' => 'HomesteadController@edit'
        ]);

        Route::post('edit/{id}', [
            'as'   => 'homestead.edit',
            'uses' => 'HomesteadController@update'
        ]);

        Route::get('delete/{id}', [
            'as'   => 'homestead.delete',
            'uses' => 'HomesteadController@destroy'
        ]);
    });
});

resourceRoute('GroupController', 'group', 'active:groups');
resourceRoute('SettingController', 'setting', 'active:settings');

Route::group(['prefix' => 'directory'], function () {
    Route::get('lookup', [
        'as'   => 'directory.lookup',
        'uses' => 'DirectoryController@lookup'
    ]);
});
