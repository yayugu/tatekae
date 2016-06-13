@extends('layouts.master')
@section('title', 'Page Title')

@section('content')
    <section>
        <div class="container">
            <h1 class="title">Register</h1>

            <form method="POST" action="{{url('/register')}}>
                {!! csrf_field() !!}

                <div>
                    Email
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>

                <div>
                    Password
                    <input type="password" name="password">
                </div>

                <div>
                    Confirm Password
                    <input type="password" name="password_confirmation">
                </div>

                <div>
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </section>
@stop