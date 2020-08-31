<?php

Route::group(['module' => 'Admin', 'middleware' => ['web'], 'prefix'=>'admin'], function() {

    Route::get('/login', function () {
        return view('Admin::login');
    });
    Route::post('/login', 'AdminController@login');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/logout', 'AdminController@logout');

        //dashboard
        Route::get('/dashboard', 'DashboardController@dashboard');
        Route::post('/data-source', 'DashboardController@dataSource');
        Route::post('/result-data-source', 'DashboardController@resultDataSource');
        Route::post('/input-question', 'DashboardController@inputQuestion');
        Route::get('/result', function () {
            return view('Admin::result');
        });



    });


});
