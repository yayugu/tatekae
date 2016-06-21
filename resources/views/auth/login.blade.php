@extends('layouts.master')
@section('title', '- Login')

@section('content')
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-three-quarters is">
                <h1 class="title">ログイン</h1>
                <form method="POST" action="{{url('/login')}}">
                    {!! csrf_field() !!}

                    <label class="label">ユーザー名（アルファベットと_(アンダースコア）のみ）</label>
                    <p class="control">
                        <input class="input" type="text" name="screen_name" value="{{ old('screen_name') }}">
                    </p>

                    <label class="label">パスワード</label>
                    <p class="control">
                        <input class="input" type="password" name="password" id="password">
                    </p>

                    <p class="control is-pulled-right">
                        <button class="button is-primary" type="submit">Login</button>
                    </p>
                </form>
            </div>
        </div>
    </section>
@stop