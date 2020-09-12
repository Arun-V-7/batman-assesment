<?php

Route::group(['module' => 'User', 'middleware' => ['web'],'prefix'=>'user'], function() {



    Route::get('/login', function () {
        return view('User::login');
    });
	Route::get('/sign-up', function () {
        return view('User::signup');
    });
	Route::post('/login', 'UserController@login');
	Route::post('/sign-up', 'UserController@signUp');

    //After login roots
    Route::group(['middleware' => ['authUser']], function () {
        //Authentication
        Route::get('/logout', 'UserController@logout');

        //Dashboard
        Route::get('/dashboard', 'DashboardController@dashboard');
        Route::post('/get-quiz-questions', 'DashboardController@getQuizQuestions');
        Route::post('/get-next-question', 'DashboardController@getNextQuestion');
        Route::post('/submit-quiz', 'DashboardController@submitQuiz');
        Route::post('/submit-quiz-answer', 'DashboardController@submitQuizAnswer');


    });

});
