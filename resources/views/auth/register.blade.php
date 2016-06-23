@extends('layouts.master')
@section('title', '- 登録')

@section('content')
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-two-thirds">
                <h1 class="title">登録</h1>

                <form method="POST" action="{{url('/register')}}">
                    {!! csrf_field() !!}

                    <label class="label">ユーザー名（アルファベットと_(アンダースコア）のみ）</label>
                    <p class="control">
                        <input class="input" type="text" name="screen_name" value="{{ old('screen_name') }}">
                    </p>

                    <label class="label">パスワード</label>
                    <p class="control">
                        <input class="input" type="password" name="password">
                    </p>

                    <label class="label">パスワード（確認）</label>
                    <p class="control">
                        <input class="input" type="password" name="password_confirm">
                    </p>

                    <p class="control is-pulled-right">
                        <button class="button is-primary" type="submit">登録</button>
                    </p>
                </form>
            </div>
        </div>
    </section>
@stop