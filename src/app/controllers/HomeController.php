<?php

class HomeController extends BaseController {

    public function home () {

        // Mail::send('emails.auth.test', array('name'=>'Alex Pi'), function ($message) {
        //     $message->to('avil13rus@gmail.com', 'Алексей Пивкин')->subject('test email');
        // });


        return View::make('home');

    }

}
