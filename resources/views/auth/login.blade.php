@extends('layouts.master')
@section('title', 'Login')

@section('content')
    <form method="POST" action="{{url('/login')}}">
        {!! csrf_field() !!}

        <div>
            Screen Name (Alphabet & underscore)
            <input type="text" name="screen_name" value="{{ old('screen_name') }}">
        </div>

        <div>
            Password
            <input type="password" name="password" id="password">
        </div>

        <div>
            <input type="checkbox" name="remember"> Remember Me
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
@stop