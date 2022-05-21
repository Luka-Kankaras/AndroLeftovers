@extends('layouts.website')

@section('title')
    {{ config('app.name') }} - {{ __('static.products') }}
@endsection

@section('meta')

    {{-- Primary Meta Tags --}}
    <meta name="title" content="ivmax® - {{ __('static.products') }}">
    <meta name="description" content="{{ $homePageInfo->subtitle }}">
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ivmax® - {{ __('static.products') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ivmax® - {{ __('static.products') }}">
    <meta name="author" content="ivmax® - {{ __('static.products') }}">
    <meta property="og:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="og:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ivmax® - {{ __('static.products') }}">
    <meta property="twitter:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="twitter:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">

@endsection

@section('content')
    <section class="section__products section__top py-4 py-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="small mb-4 mb-lg-5">
                        {{ __('static.products_title') }}
                    </h1>
                </div>
                <div class="col-12 py-3">
                    <div class="products__item__card gray__background position-relative p-3 p-lg-5">
                        @if ($products[0]->discount !== null && $products[0]->discount !== 0)
                            <div class="product__discount py-2 px-3 my-3 my-lg-0">
                                <span>
                                    -{{ $products[0]->discount }}%
                                </span>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12 col-lg-5 d-lg-flex">
                                <h2 class="big d-lg-none">
                                    {{ $products[0]->name }}
                                </h2>

                                <div class="img-wrap img-wrap-big d-flex my-lg-auto">
                                    <img data-src="{{ asset($products[0]->image) }}"
                                        class="lazy img-fluid d-block mx-auto my-4 " alt="{{ $products[0]->name }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="d-none d-lg-flex align-items-center justify-content-between">
                                    <h2 class="big mb-0">
                                        {{ $products[0]->name }}
                                    </h2>
                                </div>
                                <div class="d-flex flex-wrap my-3">
                                    @foreach ($products[0]->toothbrushColors as $toothbrushColor)
                                        <div class="available__color d-flex align-items-center my-1 mr-3">
                                            <span class="color__circle"
                                                style="background-image: linear-gradient(to right, {{ $toothbrushColor->hex }}, #ffffff, {{ $toothbrushColor->hex }});">
                                            </span>
                                            <span class="ml-2">{{ $toothbrushColor->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="my-4">
                                    {{ $products[0]->description }}
                                </p>
                                @if ($products[0]->ivmax_toothbrush_count !== null && $products[0]->ivmax_toothbrush_count !== 0 && $products[0]->brush_head_count !== null && $products[0]->brush_head_count !== 0 && $products[0]->toothpaste_cartridges_count !== null && $products[0]->toothpaste_cartridges_count !== 0)
                                    <div class="pack__includes">
                                        <h3>{{ __('static.pack_include') }}</h3>
                                        <div class="d-md-flex align-items-center">
                                            @if ($products[0]->ivmax_toothbrush_count !== null && $products[0]->ivmax_toothbrush_count !== 0)
                                                <div class="d-flex align-items-center my-3  my-md-0">
                                                    <span>{{ $products[0]->ivmax_toothbrush_count }}</span>
                                                    <p class="mb-0 ml-2 mr-3">{{ __('static.ivmax_toothbrush') }}</p>
                                                </div>
                                            @endif
                                            @if ($products[0]->brush_head_count !== null && $products[0]->brush_head_count !== 0)
                                                <div class="d-flex align-items-center my-3  my-md-0">
                                                    <span>{{ $products[0]->brush_head_count }}</span>
                                                    <p class="mb-0 ml-2 mr-3">{{ __('static.brush_head') }}</p>
                                                </div>
                                            @endif
                                            @if ($products[0]->toothpaste_cartridges_count !== null && $products[0]->toothpaste_cartridges_count !== 0)
                                                <div class="d-flex align-items-center my-3  my-md-0">
                                                    <span>{{ $products[0]->toothpaste_cartridges_count }}</span>
                                                    <p class="mb-0 ml-2 mr-3">{{ __('static.toothpaste_cartridges') }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if (count($products[0]->toothbrushTypes) !== 0)
                                    <div class="available__brush__heads mt-4">
                                        <h3>{{ __('static.available_brush_heads') }}</h3>
                                        <div class="d-md-flex align-items-center">
                                            @foreach ($products[0]->toothbrushTypes as $key => $toothbrushType)
                                                @if ($key > 0)
                                                    <span class="mx-2">
                                                        |
                                                    </span>
                                                @endif
                                                <span>
                                                    {{ $toothbrushType->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <a href="{{ $products[0]->buy_url }}" class="btn btn-primary btn__blue mt-4"
                                    target="_blank" rel="noopener">
                                    {{ __('static.buy') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 py-3">
                    <div class="annual__plan text-center">
                        <div class="annual__plan__inner">
                            <h2 class="big">
                                {{ $products[1]->name }}
                            </h2>
                            <span>
                                {{ __('static.every_3_months_or_yearly') }}
                            </span>
                            <p class="my-3 my-lg-4">
                                {{ $products[1]->description }}
                            </p>
                            <a href="{{ $products[1]->buy_url }}" class="btn btn-primary btn__blue mx-auto mt-3 mt-lg-4"
                                target="_blank" rel="noopener">
                                {{ __('static.create_your_pack') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-12 col-md-6 pb-3 pb-lg-0">
                    <div
                        class="products__item__card gray__background d-flex flex-column justify-content-between text-center position-relative p-3 p-lg-5">
                        @if ($products[2]->discount !== null && $products[2]->discount !== 0)
                            <div class="product__discount py-2 px-3 my-3 my-lg-0">
                                <span>
                                    -{{ $products[2]->discount }}%
                                </span>
                            </div>
                        @endif
                        <div class="img-wrap d-flex align-items-center justify-content-center">
                            <img data-src="{{ asset($products[2]->image) }}" class="lazy img-fluid"
                                alt="{{ $products[2]->name }}">
                        </div>
                        <h2 class="big my-4 my-lg-5">
                            {{ $products[2]->name }}
                        </h2>
                        <div class="d-flex flex-wrap justify-content-center">
                            @foreach ($products[2]->toothbrushHeadColors as $toothbrushHeadColor)
                                <div class="available__color d-flex align-items-center my-1 mx-1">
                                    <span class="color__circle"
                                        style="background-image: linear-gradient(to right, {{ $toothbrushHeadColor->hex }}, #ffffff, {{ $toothbrushHeadColor->hex }});">
                                    </span>
                                    <span class="mx-1">{{ $toothbrushHeadColor->name }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="my-4 my-lg-5">
                            {{ $products[2]->description }}
                        </p>
                        <a href="{{ $products[2]->buy_url }}" class="btn btn-primary btn__blue mx-auto" target="_blank"
                            rel="noopener">
                            {{ __('static.buy') }}
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 py-3 py-lg-0">
                    <div
                        class="products__item__card gray__background d-flex flex-column justify-content-between text-center position-relative p-3 p-lg-5">
                        @if ($products[3]->discount !== null && $products[3]->discount !== 0)
                            <div class="product__discount py-2 px-3 my-3 my-lg-0">
                                <span>
                                    -{{ $products[3]->discount }}%
                                </span>
                            </div>
                        @endif
                        <div class="img-wrap d-flex align-items-center justify-content-center">
                            <img data-src="{{ asset($products[3]->image) }}" class="lazy img-fluid"
                                alt="{{ $products[3]->name }}">
                        </div>
                        <h2 class="big my-4 my-lg-5">
                            {{ $products[3]->name }}
                        </h2>
                        @foreach ($products[3]->toothpasteTypes as $toothpasteType)
                            <span class="product__info d-block">
                                {{ $toothpasteType->name }}
                            </span>
                        @endforeach
                        <p class="my-4 my-lg-5">
                            {{ $products[3]->description }}
                        </p>
                        <a href="{{ $products[3]->buy_url }}" class="btn btn-primary btn__blue mx-auto" target="_blank"
                            rel="noopener">
                            {{ __('static.buy') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection
