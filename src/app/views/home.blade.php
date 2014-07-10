@extends('layout.main')


@section('content')

    @if(Auth::check())

        <p>Привет, {{Auth::user()->username}}.</p>

        <div ng-view></div>

    @else

        <h2>вы не зарегистрированы</h2>

    @endif

@stop

