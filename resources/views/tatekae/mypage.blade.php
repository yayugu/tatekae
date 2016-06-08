@extends('layouts.master')
@section('title', 'Page Title')

@section('content')
    <section>
        <div class="container">
            <h1 class="title">Add Account</h1>

            <form method="POST" action="/tatekae/new">
                {!! csrf_field() !!}

                <div>
                    Name
                    <input type="text" name="name" value="">
                </div>

                <div>
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </section>
@stop