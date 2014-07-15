<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/test', function () {
    $user  = User::find(1);
    $x = $user->group->name;
    dd($x);
});


/*
| В случае если пользователь авторизован,
| то здесь будут происходить все действия
| Single Page Application
*/
Route::get('/', array(
    'as'=> 'home',
    'uses'=> 'HomeController@home'
));



/*
| На случай если к пост методам решат обратиться напрямую
*/
Route::get('/api/{fun?}', function () {
    return Redirect::route('home');
});

Route::get('/user/{username?}', array(
        'as' => 'profile-user',
        'uses' => 'ProfileController@user'
    )
);


/*
| Выдача шаблонов для View Angular.JS
*/
Route::get('/template/{name}', function ($name) {
        return View::make('angular-pages.'.$name);
    }
);



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


    // Смена пароля (GET)
    Route::get('/account/change-password', array(
            'as' => 'account-change-password',
            'uses' => 'AccountController@getChangePassword'
        )
    );


    // CSRF
    Route::group(array('before'=>'csrf'), function () {
        // Смена пароля (POST)
        Route::post('/account/change-password', array(
                'as' => 'account-change-password-post',
                'uses' => 'AccountController@postChangePassword'
            )
        );
    });


    /**
     * роуты внутри админки
     */
    include 'routes/auth_routes.php';


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


        // Забыли пароль (POST)
        Route::post('/account/forgot', array(
                'as' => 'account-forgot-password-post',
                'uses' => 'AccountController@postForgotPassword'
            )
        );

    });
    // /////////////////////



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



    // Забыли пароль (GET)
    Route::get('/account/forgot', array(
            'as' => 'account-forgot-password',
            'uses' => 'AccountController@getForgotPassword'
        )
    );


    // Восстановление пароля
    Route::get('/account/recover/{code}', array(
            'as' => 'account-recover',
            'uses' => 'AccountController@getRecover'
        )
    );

});









