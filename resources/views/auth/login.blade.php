@extends('layouts.master')
@section('title', '- Login')

@section('content')
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-two-thirds">
                <h1 class="title">ログイン</h1>

                @include('parts.error_message')

                <a class="button is-primary" href="{{route('social.redirect')}}">Login with Google</a>
            </div>
        </div>
    </section>
@stop