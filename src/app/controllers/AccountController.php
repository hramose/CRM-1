<?php

class AccountController extends BaseController {

    public function getSignIn() {
        return View::make('account.signin');
    }



    public function getSignOut() {
        Auth::logout();
        return Redirect::route('home');
    }



    public function postSignIn() {
        $validator = Validator::make(Input::all(), array(
                'email' => 'required|email',
                'password' => 'required'
            )
        );

        if($validator->fails()){
            return Redirect::route('account-sign-in')
                    ->withErrors($validator)
                    ->withInput();
        }else{

            $remember = (Input::has('remember')) ? true : false;

            // авторизация прошла успешно
            $auth = Auth::attempt(array(
                    'email' => Input::get('email'),
                    'password' => Input::get('password'),
                    'active' => 1
                ),
                $remember
            );

            if($auth){
                //  Редирект на страницу с доступом авторизованному пользователю
                return Redirect::intended('/');
            }else{

                return Redirect::route('account-sign-in')
                        ->with('global', 'Не верные email или пароль, либо аккаунт не активирован.');
            }

            return Redirect::route('account-sign-in')
                    ->with('global', 'При авторизации возникли проблемы. Вы активированы?');
        }

    }



    public function getCreate() {
        return View::make('account.create');
    }



    public function postCreate() {

        $validator = Validator::make(
            Input::all(),
            array(
                'email'         =>'required|max:50|email|unique:users',
                'username'      =>'required|max:20|min:3|unique:users',
                'password'      =>'required|min:6',
                'password_again'=>'required|same:password'
            )
        );


        if ($validator->fails()) {

            return Redirect::route('account-create')
                    ->withErrors($validator)
                    ->withInput();

        }else{
            $email    = Input::get('email');
            $username = Input::get('username');
            $password = Input::get('password');

            // Activation code
            $code     = str_random(60);

            $user = User::create(array(
                    'email'    => $email,
                    'username' => $username,
                    'password' => Hash::make($password),
                    'code'     => $code,
                    'active'   => 0
                ));

            if($user){

                // Send email
                Mail::send('emails.auth.activate',
                    array('link'=>URL::route('account-activate', $code), 'username'=>$username),
                    function ($message) use ($user) {
                        $message->to($user->email, $user->username)->subject('Activate you account');
                    });

                return Redirect::route('home')
                    ->with('global', 'Ваш аккаунт создан, мы отправили вам сообщение для его активации.');
            }
        }
    }



    public function getActivate($code) {
        $user = User::where('code', '=', $code)->where('active', '=', 0);

        if($user->count()){
            $user = $user->first();

            // ОБновляем статус пользователя
            $user->active = 1;
            $user->code = '';

            if($user->save()){
                return Redirect::route('home')
                    ->with('global', 'Ваш аккаунт успешно активирован. Авторизуйтесь.');
            }
        }

        return Redirect::route('home')
            ->with('global', 'Мы не смогли активировать ваш акаунт, попытайтесь чуть позже.');
    }



    public function getChangePassword() {
        return View::make('account.password');
    }


    public function getChangePassword() {
        $validator = $Validator::make(Input::all(), array(
                'old_password'      => 'required',
                'password'      => 'required|min:6',
                'password_again'=> 'required|same:password'
            )
        );

        if($validator->fails()){
            return Redirect::route('account-change-password')
                    ->withErrors($validator);
        }else{
            // Смена пароля
            $user = User::find(Auth::user()->id);

            $old_password = Input::get('old_password');
            $password = Input::get('password');

            if(Hash::check($old_password, $user->getAuthPassword())){
                // Пароли разные все идет по плану
                $user->password = Hash::make($password);

                if($user->save()){
                    return Redirect::route('home')
                            ->with('global', 'Ваш пароль изменен.');

                }

            }
        }

        return Redirect::route('account-change-password')
                    ->with('global', 'Ваш пароль не может быть изменен.');
    }


}
















