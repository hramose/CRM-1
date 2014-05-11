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





/*
| аутентифицированные пользователи
*/
Route::group(array('before'=>'auth'), function () {
    // Sign out (GET)
    Route::get('/account/sign-out', array(
            'as' => 'account-sign-out',
            'uses' => 'AccountController@getSignOut'
        )
    );
});





// Не аутентифицированные
Route::group(array('before'=>'guest'), function () {

    // проверка на CSRF
    Route::group(array('before'=>'csrf'), function () {

        // создание аккаунта (POST)
        Route::post('/account/create', array(
            'as'=>'account-create-post',
            'uses'=>'AccountController@postCreate'
        ));



        // Авторизоваться (POST)
        Route::post('/account/sign-in', array(
            'as' => 'account-sign-in-post',
            'uses' => 'AccountController@postSignIn'
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



    // Авторизоваться (GET)
    Route::get('/account/sign-in', array(
        'as' => 'account-sign-in',
        'uses' => 'AccountController@getSignIn'
    ));
});












