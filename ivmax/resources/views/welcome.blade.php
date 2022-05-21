@extends('layouts.website',['footer_show' => false, 'header_show' => false])

@section('title')
    {{ config('app.name') }}
@endsection

@section('meta')

    {{-- Primary Meta Tags --}}
    <meta name="title" content="ivmax®">
    <meta name="description" content="{{ $homePageInfo->subtitle }}">
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ivmax®">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ivmax®">
    <meta name="author" content="ivmax®">
    <meta property="og:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="og:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ivmax®">
    <meta property="twitter:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="twitter:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">
@endsection

@section('content')
    <section class="select__region__section d-md-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 text-center">
                    <div class="logo__wrapper mb-lg-5 pb-lg-5">
                        <img data-src="{{ asset('assets/images/select-region/logo-white.png') }}" alt="Logo"
                            class="lazy mb-5">
                    </div>
                    <h1 class="small white mb-3 mb-md-5">SELECT YOUR REGION</h1>
                    <a href="https://hr.ivmax.com/help"
                        class="btn btn__transparent btn__region mx-auto my-2 m-md-3">Croatia</a>
                    <a href="https://cz.ivmax.com/help" class="btn btn__transparent btn__region mx-auto my-2 m-md-3">Czech
                        Republic</a>
                    <a href="https://me.ivmax.com/help"
                        class="btn btn__transparent btn__region mx-auto my-2 m-md-3">Montenegro</a>
                    <a href="https://sr.ivmax.com/help"
                        class="btn btn__transparent btn__region mx-auto my-2 m-md-3">Serbia</a>
                    <a href="https://it.ivmax.com/help"
                        class="btn btn__transparent btn__region mx-auto my-2 m-md-3">Italy</a>
                    <a href="{{ url('/help') }}" class="btn btn__transparent btn__region mx-auto my-2 m-md-3"
                        onclick="chooseRegion()">International</a>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    const chooseRegion = () => {
        document.cookie = `regionChosen=${true}`;
    }
</script>
