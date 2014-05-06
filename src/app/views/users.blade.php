@extends('layouts.index')

@section('content')

    {{$environment}} <br>
    <a href="{{$url}}">{{$url}}</a>
    <hr>

    @if( !empty($user) )
    <div class="hero-unit">
        {{$user->id}} <br>
        {{$user->name}} <br>
        {{$user->email}} <br>
    </div>
    <hr>
    @endif



@stop
