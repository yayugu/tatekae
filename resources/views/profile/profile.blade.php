@extends('layouts.master')
@section('title', '- Dashboard')

@section('content')
    @include('parts.error_message')

    <section class="section">
        <div class="container">
            <form method="POST" action="{{action('UserRelationshipController@postNew')}}">
                {!! csrf_field() !!}
                <p class="control has-addons">
                    <input class="input is-expanded" type="text" name="screen_name" placeholder="Twitter username (ex. @foobar) ">
                    <button type="submit" class="button is-primary">友達を追加</button>
                </p>
                <p class="control">
                </p>
            </form>
        </div>
    </section>

@stop