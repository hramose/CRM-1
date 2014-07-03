@extends('layout.main')

@section('content')

{{ Form::open(array('url' => URL::route('account-sign-in-post'))) }}
    <br>
    {{ Form::label('email', 'Адрес e-mail:') }}
    {{ Form::email('email', '', array('placeholder'=>'example@gmail.com'))}}
    @if($errors->has('email'))
        {{ $errors->first('email') }}
    @endif
    <br>

    {{ Form::label('password', 'Пароль:') }}
    {{ Form::password('password')}}
    @if($errors->has('password'))
        {{ $errors->first('password') }}
    @endif
    <br>

    {{ Form::label('remember', 'Запомнить меня:') }}
    {{ Form::checkbox('remember') }}

    <br>
    {{ Form::submit('Авторизоваться') }}

{{ Form::close() }}



@stop