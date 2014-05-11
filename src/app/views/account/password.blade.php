@extends('layout.main')


@section('content')

{{ Form::open('url'=>URL::route('account-change-password-post')) }}

    {{ Form::label('old_password', 'Старый пароль:') }}
    {{ Form::password('old_password') }}
    @if($errors->has('old_password'))
        {{ $errors->first('old_password') }}
    @endif
    <br>

    {{ Form::label('password', 'Новый пароль:') }}
    {{ Form::password('password') }}
    @if($errors->has('password'))
        {{ $errors->first('password') }}
    @endif
    <br>

    {{ Form::label('password_again', 'Новый пароль:') }}
    {{ Form::password('password_again') }}
    @if($errors->has('password_again'))
        {{ $errors->first('password_again') }}
    @endif
    <br>



    {{ Form::submit('Изменить пароль') }}
{{ Form::close() }}



@stop