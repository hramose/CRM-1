@extends('layout.main')

@section('content')

{{ Form::open( array('url' => URL::route('account-forgot-password-post')) ) }}

    {{ Form::label('email', 'Укажите свой email') }}
    {{ Form::email('email') }}
    @if($errors->has('email'))
        {{ $errors->first('email') }}
    @endif

    {{ Form::submit('Восстановить пароль') }}
{{ Form::close() }}

@stop