@extends('layouts.website')

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

    <style>
        .home__cover__section {
            background: url({{ $homePageInfo->thumbnail_big }}) no-repeat center / cover;
        }

        @media (max-width: 991px) {
            .home__cover__section {
                background: url({{ $homePageInfo->thumbnail_small }}) no-repeat top / cover;
            }
        }

    </style>
@endsection

@section('content')
    <section
        class="home__cover__section d-flex flex-row justify-content-center align-items-end align-items-lg-start text-center text-lg-left flex-lg-column py-5">
        <div class="container">
            <h1 class="mb-4 mb-lg-5 big">
                {{ $homePageInfo->title }}
            </h1>
            <p class="mb-4 mb-lg-5 big">
                {{ $homePageInfo->subtitle }}
            </p>
            <a href="https://shop.ivmax.com/" class="btn btn-primary btn__blue mt-3 mt-lg-0" target="_blank" rel="noopener">
                {{ __('static.order_yours') }}
            </a>
        </div>
    </section>
    <section class="home__choose__plan__section py-5">
        <div class="container text-center home__choose__plan__container position-relative">
            <div class="home__choose__background"></div>
            <h1 class="small mb-3 mb-lg-4">
                <span>
                    {{ __('static.toothbrush_toothpaste') }}
                </span>
            </h1>
            <p class="mt-3 mt-lg-4 mb-0 mx-auto">
                {{ $homePageInfo->text_1 }}
            <p class="bold mx-auto">
                {{ $homePageInfo->text_2 }}
            </p>
            <a href="{{ url('products') }}" class="btn btn-primary btn__blue mt-4">
                {{ __('static.view_all_products') }}
            </a>
        </div>
    </section>
    <section class="home__ivmax__anatomy__section py-4 pt-5 py-md-5 ">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1 class="mb-4 mb-lg-5 white">
                        {{ __('static.ivmax') }} <span class="gold d-block">{{ __('static.anatomy') }}</span>
                    </h1>
                    <p class="mb-3 mb-md-0 white">
                        {{ $homePageInfo->ivmax_anatomy }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-md-12 buttons__wrapper d-flex align-items-center justify-content-center">
                    <div class="row buttons flex-column-reverse flex-md-row justify-content-center my-5">
                        <div class="col-12 col-md-3">
                            <button class="tootbrush__button d-block m-auto" onclick="toggleToothbrushDescription(this, 1)">
                                <img data-src="{{ asset('assets/images/home/tootbrush/part-1.png') }}"
                                    class="lazy img-fluid" alt="Tootbrush part 1">
                            </button>
                        </div>
                        <div class="col-12 col-md-2">
                            <button class="tootbrush__button small d-block m-auto"
                                onclick="toggleToothbrushDescription(this, 2)">
                                <img data-src="{{ asset('assets/images/home/tootbrush/part-2.png') }}"
                                    class="lazy img-fluid" alt="Tootbrush part 2">
                            </button>
                        </div>
                        <div class="col-12 col-md-3">
                            <button class="tootbrush__button active d-block m-auto"
                                onclick="toggleToothbrushDescription(this, 3)">
                                <img data-src="{{ asset('assets/images/home/tootbrush/part-3.png') }}"
                                    class="lazy img-fluid" alt="Tootbrush part 3">
                            </button>
                        </div>
                        <div class="col-12 col-md-3">
                            <button class="tootbrush__button d-block m-auto" onclick="toggleToothbrushDescription(this, 4)">
                                <img data-src="{{ asset('assets/images/home/tootbrush/part-4.png') }}"
                                    class="lazy img-fluid" alt="Tootbrush part 4">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-7 col-md-12 tootbrush__description__wrapper d-flex">
                    <div class="tootbrush__description">
                        <div id="text1" class="tootbrush__text row d-none">
                            <div class="col-12 col-md-3 white">
                                <h2 class="mb-4 mb-md-0 white position-relative">{{ __('static.text_1') }}</h2>
                                <span class="line"></span>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="white">{{ __('static.text_1_description') }}</p>
                            </div>
                        </div>
                        <div id="text2" class="tootbrush__text row d-none">
                            <div class="col-12 col-md-3 white">
                                <h2 class="mb-4 mb-md-0 white position-relative">{{ __('static.text_2') }}</h2>
                                <span class="line"></span>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="white">{{ __('static.text_2_description') }}</p>
                            </div>
                        </div>
                        <div id="text3" class="tootbrush__text row">
                            <div class="col-12 col-md-3 white">
                                <h2 class="mb-4 mb-md-0 white position-relative">{{ __('static.text_3') }}</h2>
                                <span class="line"></span>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="white">{{ __('static.text_3_description') }}</p>
                            </div>
                        </div>
                        <div id="text4" class="tootbrush__text row d-none">
                            <div class="col-12 col-md-3 white">
                                <h2 class="mb-4 mb-md-0 white position-relative">{{ __('static.text_4') }}</h2>
                                <span class="line"></span>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="white">{{ __('static.text_4_description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home__always__at__hand__section position-relative">
        <div class="container home__always__at__hand__container position-relative">
            <div class="home__always__at__hand__background"></div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1 class="small mb-4 mb-lg-5">
                        {{ __('static.our_exclusive_features') }}
                    </h1>
                    <div class="row">
                        <div class="col-12 col-lg-6 my-4">
                            <div class="d-flex align-items-center mb-4">
                                <img data-src="{{ asset('assets/images/home/features/Always at Hand.png') }}"
                                    alt="{{ __('static.always_at_hand') }}" class="lazy mr-4">
                                <p class="bold mb-0">{{ __('static.always_at_hand') }}</p>
                            </div>
                            <p>
                                {{ $homePageInfo->feature_1 }}
                            </p>
                        </div>
                        <div class="col-12 col-lg-6 my-4">
                            <div class="d-flex align-items-center mb-4">
                                <img data-src="{{ asset('assets/images/home/features/Perfect for Outdoors.png') }}"
                                    alt="{{ __('static.perfect_for_outdoors') }}" class="lazy mr-4">
                                <p class="bold mb-0">{{ __('static.perfect_for_outdoors') }}</p>
                            </div>
                            <p>
                                {{ $homePageInfo->feature_2 }}
                            </p>
                        </div>
                        <div class="col-12 col-lg-6 my-4">
                            <div class="d-flex align-items-center mb-4">
                                <img data-src="{{ asset('assets/images/home/features/Expert Construction.png') }}"
                                    alt="{{ __('static.expert_construction') }}" class="lazy mr-4">
                                <p class="bold mb-0">{{ __('static.expert_construction') }}</p>
                            </div>
                            <p>
                                {{ $homePageInfo->feature_3 }}
                            </p>
                        </div>
                        <div class="col-12 col-lg-6 my-4">
                            <div class="d-flex align-items-center mb-4">
                                <img data-src="{{ asset('assets/images/home/features/Airplane Safety.png') }}"
                                    alt="{{ __('static.airplane_friendly') }}" class="lazy mr-4">
                                <p class="bold mb-0">{{ __('static.airplane_friendly') }}</p>
                            </div>
                            <p>
                                {{ $homePageInfo->feature_4 }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 circle__wrap d-flex justify-content-end">
                    <div class="circle position-relative d-flex align-items-center justify-content-center text-right">
                        <h2 class="big white position-relative">
                            {{ __('static.brush_your_teeth_anytime') }}

                        </h2>
                        <img data-src="{{ asset('assets/images/home/always-at-hand.png') }}" class="lazy hand__image"
                            alt="{{ __('static.brush_your_teeth_anytime') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home__subscribe__section position-relative">
        <div class="container home__subscribe__container p-4 p-sm-5">
            <div class="home__subscribe__background"></div>
            <div class="row text-center text-lg-left">
                <div class="col-lg-8 d-none d-lg-flex">
                    @if ($homePageInfo->video_ext === 'jpeg' || ($homePageInfo->video_ext === 'jpg' || $homePageInfo->video_ext === 'png'))
                        <img data-src="{{ asset($homePageInfo->photo_or_video) }}" alt="ivmax_lifestyle_f_1"
                            class="lazy img-fluid m-auto">
                    @else
                        <video autoplay muted loop playsinline class="video__cover ml-sm-2">
                            <source src="{{ $homePageInfo->photo_or_video }}" type="video/mp4">
                            <source src="{{ $homePageInfo->photo_or_video }}" type="video/ogg">
                            Your browser does not support HTML video.
                        </video>
                    @endif
                </div>
                <div class="col-12 col-lg-4">
                    <h1 class="small mt-4 mt-lg-5">
                        {{ __('static.subscribe_annual') }}
                        <span class="blue d-block">{{ __('static.and_save') }}</span>
                    </h1>
                    <p class="mt-3 mt-lg-4">
                        {{ $homePageInfo->annual_text_1 }}
                    </p>
                    <p class="mt-3 mt-lg-4">
                        {{ $homePageInfo->annual_text_2 }}
                    </p>
                    <a href="https://shop.ivmax.com/products/subscription" class="btn btn-primary btn__blue my-4"
                        target="_blank" rel="noopener">
                        {{ __('static.learn_more') }}
                    </a>

                </div>
            </div>
        </div>
        <div class="d-lg-none m-auto">
            @if ($homePageInfo->video_ext === 'jpeg' || ($homePageInfo->video_ext === 'jpg' || $homePageInfo->video_ext === 'png'))
                <img data-src="{{ asset($homePageInfo->photo_or_video) }}" alt="ivmax_lifestyle_f_1"
                    class="lazy img-fluid ">
            @else
                <video autoplay muted loop playsinline class="video__cover ml-sm-2">
                    <source src="{{ $homePageInfo->photo_or_video }}" type="video/mp4">
                    <source src="{{ $homePageInfo->photo_or_video }}" type="video/ogg">
                    Your browser does not support HTML video.
                </video>
            @endif
        </div>
    </section>
    <section class="testimonials__section py-5">
        <div class="container text-center">
            <span class="blue text-uppercase">
                {{ __('static.what_our_clients_say') }}
            </span>
            <h1 class="small mb-5">
                {{ __('static.testimonials') }}
            </h1>
            <div id="cardsSlider" class="owl-carousel text-left my-4">
                @foreach ($testimonials as $item)
                    <div class="item px-3">
                        <div class="client__card position-relative d-flex flex-column justify-content-between mx-auto p-4">
                            <div class="img-wrap">
                                <img data-src="{{ asset($item->photo) }}" alt="Erik Eiffel" class="lazy img-fluid">
                            </div>
                            <p class="mt-5">
                                {!! $item->text !!}
                            </p>
                            <div>
                                <span class="name d-block">
                                    {{ $item->first_name }}
                                    {{ $item->last_name }}
                                </span>
                                <span class="country d-block">
                                    {{ $item->city }},
                                    {{ $item->country }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="home__style__section position-relative py-5 py-md-5" id="homeStyleSection">
        <div class="circle__1"></div>
        <div class="circle__2"></div>
        <div class="container home__style__container">
            <div class="row text-left">
                <div class="col-12 col-lg-6 d-flex justify-content-center justify-content-lg-end">
                    <img data-src="{{ asset('assets/images/home/style-backgrounds/Silver.png') }}" alt="Silver"
                        id="activeGray" class="lazy tootbrush__img img-fluid">
                    <img data-src="{{ asset('assets/images/home/style-backgrounds/Azure.png') }}" alt="Azure"
                        id="activeBlue" class="lazy tootbrush__img img-fluid">
                    <img data-src="{{ asset('assets/images/home/style-backgrounds/Royal.png') }}" alt="Royal"
                        id="activeRose" class="lazy tootbrush__img img-fluid active">
                    <img data-src="{{ asset('assets/images/home/style-backgrounds/Black.png') }}" alt="Black"
                        id="activeBlack" class="lazy tootbrush__img img-fluid">
                    <img data-src="{{ asset('assets/images/home/style-backgrounds/Rose Gold.png') }}" alt="Gold"
                        id="activeGold" class="lazy tootbrush__img img-fluid">
                </div>
                <div
                    class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-left">
                    <h1 class="small my-5">
                        {{ __('static.find_your') }} <span class="blue">{{ __('static.style') }}</span>
                    </h1>
                    <p class="big bold mb-0">
                        {{ __('static.five_unique_colors') }}
                    </p>
                    <p class="big bold mb-0">
                        {{ __('static.which_one_goes_with_your_character') }}
                    </p>
                    <div class="five__colors d-block mt-5">
                        <button onclick="selectColor(this, 'Gray')" id="colorGray"
                            class="color color-gray px-0 mr-2 mr-sm-3" aria-label="Silver color">
                            <img data-src="{{ asset('assets/images/home/style-backgrounds/circle-silver.png') }}"
                                alt="Silver" class="lazy">
                            <span class="d-block text-uppercase mt-2">Silver</span>
                        </button>
                        <button onclick="selectColor(this, 'Blue')" id="colorBlue"
                            class="color color-blue px-0 mr-2 mr-sm-3" aria-label="Azure color">
                            <img data-src="{{ asset('assets/images/home/style-backgrounds/circle-azure.png') }}"
                                alt="Azure" class="lazy">
                            <span class="d-block text-uppercase mt-2">Azure</span>
                        </button>
                        <button onclick="selectColor(this, 'Rose')" id="colorRose"
                            class="color color-rose px-0 mr-2 mr-sm-3 active" aria-label="Royal color">
                            <img data-src="{{ asset('assets/images/home/style-backgrounds/circle-royal.png') }}"
                                alt="Royal" class="lazy">
                            <span class="d-block text-uppercase mt-2">Royal</span>
                        </button>
                        <button onclick="selectColor(this, 'Black')" id="colorBlack"
                            class="color color-black px-0 mr-2 mr-sm-3" aria-label="Black color">
                            <img data-src="{{ asset('assets/images/home/style-backgrounds/circle-black.png') }}"
                                alt="Black" class="lazy">
                            <span class="d-block text-uppercase mt-2">Black</span>
                        </button>
                        <button onclick="selectColor(this, 'Gold')" id="colorGold" class="color color-gold px-0"
                            aria-label="Gold color">
                            <img data-src="{{ asset('assets/images/home/style-backgrounds/circle-gold.png') }}"
                                alt="Rose" class="lazy">
                            <span class="d-block text-uppercase mt-2">Rose Gold</span>
                        </button>
                    </div>
                    <a href="https://shop.ivmax.com/" class="btn btn-primary btn__blue mt-5" target="_blank"
                        rel="noopener">
                        {{ __('static.order_yours') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            initSlider();
        });
    </script>

@endsection
