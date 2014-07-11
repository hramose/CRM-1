@extends('layout.main')


@section('content')

    @if(Auth::check())

        <p>Привет, <b>{{Auth::user()->username}}</a>.</p>

        <div ng-view></div>

    @else

        <h2>вы не зарегистрированы</h2>

    @endif

@stop

