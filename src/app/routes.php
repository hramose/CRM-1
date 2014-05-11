<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', array(
    'as'=> 'home',
    'uses'=> 'HomeController@home'
));



// Не аутентифицированные
Route::group(array('before'=>'guest'), function () {

    // проверка на CSRF
    Route::group(array('before'=>'csrf'), function () {

        // создание аккаунта (POST)
        Route::post('/account/create', array(
            'as'=>'account-create-post',
            'uses'=>'AccountController@postCreate'
        ));

    });


    // создание аккаунта (GET)
    Route::get('/account/create', array(
        'as'=>'account-create',
        'uses'=>'AccountController@getCreate'
    ));

    Route::get('/account/activate/{code}', array(
        'as' => 'account-activate',
        'uses' => 'AccountController@getActivate'
    ));
});

