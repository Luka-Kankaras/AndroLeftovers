@extends('layouts.website')

@section('title')
    {{ config('app.name') }} - {{ __('static.help') }}
@endsection

@section('meta')

    {{-- Primary Meta Tags --}}
    <meta name="title" content="ivmax® - {{ __('static.help') }}">
    <meta name="description" content="{{ $homePageInfo->subtitle }}">
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ivmax® - {{ __('static.help') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ivmax® - {{ __('static.help') }}">
    <meta name="author" content="ivmax® - {{ __('static.help') }}">
    <meta property="og:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="og:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ivmax® - {{ __('static.help') }}">
    <meta property="twitter:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="twitter:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">

@endsection

@section('content')
    <section class="section__general__info section__top pt-4 py-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="small mb-4 mb-lg-5">
                        {{ __('static.general_info') }}
                    </h1>
                </div>
            </div>
            <div id="collapseWrapper" class="row collapse__wrapper position-relative">
                <div class="blog__circle__1"></div>
                <div class="col-12 col-lg-4">
                    @foreach ($infoCategory as $key => $category)
                        <div id="headingsLarge{{ $category->id }}" class="d-none d-lg-block">
                            <button
                                class="btn btn-link d-flex align-items-center px-0 py-3 {{ $key === 0 ? '' : 'collapsed' }}"
                                type="button" data-toggle="collapse" data-target="#annualPlanLarge{{ $category->id }}"
                                aria-expanded="true" aria-controls="annualPlanLarge{{ $category->id }}">
                                <span class="line"></span>
                                <p class="bold heading heading__main d-block mb-0">
                                    {{ $category->name }}
                                </p>
                            </button>
                        </div>
                        <div id="headings{{ $category->id }}" class="d-lg-none">
                            <button class="btn btn-link btn-link-small d-flex align-items-center px-0 py-3 collapsed }}"
                                type="button" data-toggle="collapse" data-target="#annualPlan{{ $category->id }}"
                                aria-expanded="true" aria-controls="annualPlan{{ $category->id }}">
                                <span class="line"></span>
                                <p class="bold heading heading__main d-block mb-0">
                                    {{ $category->name }}
                                </p>
                            </button>
                        </div>
                        <div id="annualPlan{{ $category->id }}" class="collapse d-lg-none"
                            aria-labelledby="headings{{ $category->id }}" data-parent="#collapseWrapper">
                            @foreach ($generalInfo as $info)
                                @if ($info->info_category_id === $category->id)
                                    <div class="card">
                                        <div class="card-header p-0"
                                            id="annualPlan{{ $category->id }}{{ $info->id }}">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link d-flex align-items-center px-0 py-3 collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#collapse{{ $category->id }}{{ $info->id }}"
                                                    aria-expanded="true"
                                                    aria-controls="collapse{{ $category->id }}{{ $info->id }}">
                                                    <span class="plus">+</span>
                                                    <span class="minus">-</span>
                                                    <p class="bold heading d-block mb-0 ml-4">
                                                        {{ $info->name }}
                                                    </p>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapse{{ $category->id }}{{ $info->id }}" class="collapse"
                                            aria-labelledby="annualPlan{{ $category->id }}{{ $info->id }}"
                                            data-parent="#annualPlan{{ $category->id }}">
                                            <div class="card-body p-3">
                                                <p class="ml-2">
                                                    {!! $info->description !!}
                                                </p>
                                                @if ($info->video !== null)
                                                    <video autoplay muted controls loop playsinline
                                                        class="video__cover ml-sm-2">
                                                        <source src="{{ $info->video }}" type="video/mp4">
                                                        <source src="{{ $info->video }}" type="video/ogg">
                                                        Your browser does not support HTML video.
                                                    </video>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="col-12 col-lg-8 d-none d-lg-block">
                    @foreach ($infoCategory as $key => $category)
                        <div id="annualPlanLarge{{ $category->id }}"
                            class="collapse {{ $key === 0 ? 'show' : 'collapsing' }}"
                            aria-labelledby="headingsLarge{{ $category->id }}" data-parent="#collapseWrapper">
                            @foreach ($generalInfo as $info)
                                @if ($info->info_category_id === $category->id)
                                    <div class="card">
                                        <div class="card-header p-0"
                                            id="annualPlanLarge{{ $category->id }}{{ $info->id }}">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link d-flex align-items-center px-0 py-3 collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#collapseLarge{{ $category->id }}{{ $info->id }}"
                                                    aria-expanded="true"
                                                    aria-controls="collapseLarge{{ $category->id }}{{ $info->id }}">
                                                    <span class="plus">+</span>
                                                    <span class="minus">-</span>
                                                    <p class="bold heading d-block mb-0 ml-4">
                                                        {{ $info->name }}
                                                    </p>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseLarge{{ $category->id }}{{ $info->id }}"
                                            class="collapse"
                                            aria-labelledby="annualPlanLarge{{ $category->id }}{{ $info->id }}"
                                            data-parent="#annualPlanLarge{{ $category->id }}">
                                            <div class="card-body p-3">
                                                <p class="ml-2">
                                                    {!! $info->description !!}
                                                </p>
                                                @if ($info->video !== null)
                                                    <video autoplay muted controls loop playsinline
                                                        class="video__cover ml-sm-2">
                                                        <source src="{{ $info->video }}" type="video/mp4">
                                                        <source src="{{ $info->video }}" type="video/ogg">
                                                        Your browser does not support HTML video.
                                                    </video>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="section__faqs pt-4 py-sm-5">
        <div class="container">
            <div class="row position-relative">
                <div class="col-12">
                    <h1 class="small mb-4 mb-lg-5">
                        {{ __('static.faq') }}
                    </h1>
                </div>
                <div class="col-12">
                    <div class="collapse__wrapper" id="faqs">
                        @foreach ($faqs as $faq)
                            <div class="card">
                                <div class="card-header p-0" id="faq{{ $faq->id }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link d-flex align-items-center px-0 py-3 collapsed"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapsefaqs{{ $faq->id }}" aria-expanded="true"
                                            aria-controls="collapsefaqs{{ $faq->id }}">
                                            <span class="plus">+</span>
                                            <span class="minus">-</span>
                                            <p class="bold heading d-block ml-4 mb-0">
                                                {{ $faq->question }}
                                            </p>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsefaqs{{ $faq->id }}" class="collapse"
                                    aria-labelledby="faq{{ $faq->id }}" data-parent="#faqs">
                                    <div class="card-body p-3">
                                        <p class="ml-2">
                                            {!! $faq->answer !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section__contact pt-4 py-sm-5">
        <div class="container">
            <div class="row position-relative blue__background align-items-stretch px-sm-2 px-lg-5 pt-4 pt-lg-5">
                <div class="blog__circle__2"></div>
                <div class="col-12 col-lg-6 pb-4 pb-lg-5 d-flex flex-column justify-content-center">
                    <h1 class="small white mb-4 mb-lg-5">
                        {{ __('static.contact_support') }}
                    </h1>
                    <contact-form full_name_label="{{ __('static.full_name') }}"
                        message_label="{{ __('static.message') }}" send_label="{{ __('static.send') }}"
                        form_successful_submit="{{ __('static.form_successful_submit') }}"></contact-form>
                </div>
                <div class="col-12 col-lg-6 d-flex align-flex-end">
                    <img data-src="{{ asset('assets/images/help/contact.png') }}" alt="Contact form background"
                        class="lazy contact__image img-fluid d-block mx-auto">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
