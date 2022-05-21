@extends('layouts.website',['footer_show' => false])

@section('title')
    {{ config('app.name') }}
@endsection

@section('meta')

    <!-- Primary Meta Tags -->
    <meta name="title" content="ivmax®">
    <meta name="description" content="ivmax®">
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    <!-- Open Graph / Facebook -->
    <meta property="og:site_name" content="ivmax®">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ivmax®">
    <meta name="author" content="ivmax®">
    <meta property="og:description" content="ivmax®">
    <meta property="og:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ivmax®">
    <meta property="twitter:description" content="ivmax®">
    <meta property="twitter:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">

@endsection

@section('content')

    <section
        class="error__section error__500__section section__top d-flex flex-column justify-content-between align-items-space-between pb-5 px-lg-5 text-center">
        <div class="img-wrap">
            <img data-src="{{ asset('assets/images/errors/500.png') }}" alt="Error 500"
                class="lazy img-fluid d-block mx-auto">
        </div>
        <div class="mb-5">
            <span class="d-block mx-auto blue">
                {{ __('static.error_500') }}
            </span>
            <span class="d-block mx-auto black">
                {{ __('static.internal_server_error') }}
            </span>
        </div>
    </section>

@endsection

@section('js')

@endsection
