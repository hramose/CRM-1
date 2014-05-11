<?php

class AccountController extends BaseController {

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


}
















