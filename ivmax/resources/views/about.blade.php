@extends('layouts.website')

@section('title')
    {{ config('app.name') }} - {{ __('static.about') }}
@endsection

@section('meta')

    {{-- Primary Meta Tags --}}
    <meta name="title" content="ivmax® - {{ __('static.about') }}">
    <meta name="description" content="{{ $homePageInfo->subtitle }}">
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ivmax® - {{ __('static.about') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ivmax® - {{ __('static.about') }}">
    <meta name="author" content="ivmax® - {{ __('static.about') }}">
    <meta property="og:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="og:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ivmax® - {{ __('static.about') }}">
    <meta property="twitter:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="twitter:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">

@endsection

@section('content')
    <section class="section__about section__top py-4 py-sm-5">
        <div class="container position-relative">
            <div class="about__circle__1"></div>
            <div class="row align-items-center flex-column-reverse flex-lg-row">
                <div class="col-12 col-lg-6">
                    <h1 class="small mb-4 mb-sm-5 d-none d-lg-block">
                        {{ __('static.all_in_one_toothbrush_solution') }}
                    </h1>
                    <div class="regular__black">
                        {!! $about->section_1 !!}
                    </div>
                    <div class="bold__blue">
                        {!! $about->section_1_bold !!}
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h1 class="small mb-4 mb-sm-5 d-lg-none">
                        {{ __('static.all_in_one_toothbrush_solution') }}
                    </h1>
                    <div class="img-wrap-big my-4 my-lg-0">
                        <img data-src="{{ $about->photo_1 }}" class="lazy img-fluid d-block mx-auto" alt="Tootbrushes">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section__who__are__we py-4 py-sm-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <h1 class="small mb-4 mb-sm-5 d-lg-none">
                        {{ __('static.who_we_are') }}
                    </h1>
                    <div class="img-wrap-big my-4 my-lg-0">
                        <img data-src="{{ $about->photo_2 }}" class="lazy img-fluid d-block mx-auto" alt="Tootbrushes">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h1 class="small mb-4 mb-sm-5 d-none d-lg-block">
                        {{ __('static.who_we_are') }}
                    </h1>
                    <div class="regular__black">
                        {!! $about->section_2 !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section__our__team py-4 py-sm-5">
        <div class="container position-relative">
            <div class="about__circle__2"></div>
            <div class="about__circle__3"></div>
            <div class="row justify-content-center text-center">
                <div class="col-12 text-left text-md-center">
                    <h1 class="mb-4 mb-sm-5">
                        {{ __('static.our_team') }}
                    </h1>
                </div>
                @foreach ($team as $teamMember)
                    <div class="col-12 col-sm-6 col-xl-4 px-3 my-4">
                        <div class="person">
                            <div class="small-img-wrap d-block mx-auto mb-4">
                                <img data-src="{{ $teamMember->image }}" alt="Team member" class="lazy">
                            </div>
                            <div class="person__details">
                                <span
                                    class="name d-block">{{ $teamMember->first_name . ' ' . $teamMember->last_name }}</span>
                                <span class="position d-block">{{ $teamMember->position }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection
