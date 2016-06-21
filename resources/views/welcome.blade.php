@extends('layouts.master')
@section('title', 'Tatekae')
@section('section-option', 'is-fullheight')

@section('hero-body')
    <!-- Hero content: will be in the middle -->
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                Tatekae
            </h1>
            <h2 class="subtitle">
                立替をメモしよう。自分用にも、相手との確認にも
            </h2>
        </div>
    </div>

    <!-- Hero footer: will stick at the bottom -->
    <div class="hero-foot">
        <nav class="tabs">
            <div class="container">
                <ul>
                    <li class="is-active"><a>Overview</a></li>
                    <li><a>Modifiers</a></li>
                    <li><a>Grid</a></li>
                    <li><a>Elements</a></li>
                    <li><a>Components</a></li>
                    <li><a>Layout</a></li>
                </ul>
            </div>
        </nav>
    </div>
@stop