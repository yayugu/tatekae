@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Add Account</h1>

            <form method="POST" action="{{url('/tatekae/new')}}">
                {!! csrf_field() !!}

                <label class="label">Name</label>
                <p class="control">
                    <input type="text" class="input" name="name" value="">
                </p>

                <p class="control">
                    <button type="submit" class="button is-primary">Submit</button>
                </p>
            </form>
        </div>
    </section>
@stop