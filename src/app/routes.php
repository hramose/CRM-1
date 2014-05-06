<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

// App::abort(404, 'Страница не найдена.');



Route::any('/', function() {
    $url = URL::to('users');
    $users = User::all();

    return View::make('users')
                    ->with('users', $users)
                    ->with('url', $url)
                    ->with('environment', App::environment());
});


/*
  Route::model('user_id', 'User');

  Route::get('users/{user_id?}', function ($user_id=0) {

  $user = $user_id;
  $users = User::all();
  $environment = App::environment();
  $url = URL::to('users');

  return View::make('users')
  ->with('user', $user)
  ->with('url', $url)
  ->with('users', $users)
  ->with('environment', $environment);

  })->where(array('user_id' => '[0-9]+'));
 */



Route::group(array('prefix' => 'admin'), function () {

    Route::get('/', array('as' => 'administrator', 'uses' => 'Admin@index'));
});






