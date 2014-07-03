@extends('layout.main')

@section('content')

{{ Form::open(array('url' => URL::route('account-create-post'))) }}
    <hr>
    {{ Form::label('email', 'Адрес e-mail') }}
    {{ Form::email('email', '', array('placeholder'=>'example@gmail.com'))}}
    @if($errors->has('email'))
        {{ $errors->first('email') }}
    @endif
    <br>
    {{ Form::label('username', 'Имя') }}
    {{ Form::text('username')}}
    @if($errors->has('username'))
        {{ $errors->first('username') }}
    @endif
    <br>
    {{ Form::label('password', 'Пароль') }}
    {{ Form::password('password')}}
    @if($errors->has('password'))
        {{ $errors->first('password') }}
    @endif
    <br>
    {{ Form::label('password_again', 'Пароль') }}
    {{ Form::password('password_again')}}
    @if($errors->has('password_again'))
        {{ $errors->first('password_again') }}
    @endif
    <br>



    {{ Form::submit('Зарегистрироваться') }}

{{ Form::close() }}


@stop
