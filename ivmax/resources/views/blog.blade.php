@extends('layouts.website')

@section('title')
    {{ config('app.name') }} - {{ __('static.blog') }}
@endsection

@section('meta')

    {{-- Primary Meta Tags --}}
    <meta name="title" content="ivmax® - {{ __('static.blog') }}">
    <meta name="description" content="{{ $homePageInfo->subtitle }}">
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ivmax® - {{ __('static.blog') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ivmax® - {{ __('static.blog') }}">
    <meta name="author" content="ivmax® - {{ __('static.blog') }}">
    <meta property="og:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="og:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ivmax® - {{ __('static.blog') }}">
    <meta property="twitter:description" content="{{ $homePageInfo->subtitle }}">
    <meta property="twitter:image" content="{{ asset('assets/images/share.png') }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">

@endsection

@section('content')
    <section class="section__blogs section__top pt-4 py-sm-5">
        <div class="container">
            @if (count($posts) > 0 || count($postMain) > 0)
                <h1>{{ __('static.blog') }}</h1>
                @if ($posts->currentPage() == 1)
                    <div class="blog__card big my-4 my-lg-5">
                        <a href="{{ url('blog-single/' . $postMain[0]->id) }}">
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    <div class="img-wrap">
                                        <img data-src="{{ asset($postMain[0]->thumbnail) }}"
                                            alt="{{ $postMain[0]->title }}" class="lazy">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="date my-3 my-lg-0 mb-lg-4">
                                        {{ date('d.m.Y.', strtotime($postMain[0]->created_at)) }}
                                    </div>
                                    <div class="blog__info d-flex flex-column justify-content-between">
                                        <div>
                                            <h2 class="big my-0">
                                                {{ $postMain[0]->title }}
                                            </h2>
                                            <p class="my-4">
                                                {!! strlen(preg_replace('/(<.+?>|<.+|<)/', '', $postMain[0]->text)) > 300 ? substr(preg_replace('/(<.+?>|<.+|<)/', '', $postMain[0]->text), 0, 300) . '...' : preg_replace('/(<.+?>|<.+|<)/', '', $postMain[0]->text) !!}
                                            </p>
                                        </div>
                                        <div
                                            class="person d-flex align-items-center justify-content-start my-3 my-lg-0 mt-lg-4">
                                            <div class="small-img-wrap mr-3">
                                                <img data-src="{{ $postMain[0]->team->image }}"
                                                    alt="{{ $postMain[0]->team->full_name }}" class="lazy">
                                            </div>
                                            <div class="person__details">
                                                <span class="name d-block">{{ $postMain[0]->team->full_name }}</span>
                                                <span class="position d-block">{{ $postMain[0]->team->position }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (count($posts) > 0)
                    <div class="row position-relative">
                        <div class="blog__circle__1"></div>
                        <div class="blog__circle__2"></div>
                        @foreach ($posts as $postSingle)
                            <div class="blog__card col-12 col-lg-6 my-4">
                                <a href="{{ url('blog-single/' . $postSingle->id) }}">
                                    <div class="img-wrap">
                                        <img data-src="{{ asset($postSingle->thumbnail) }}"
                                            alt="{{ $postSingle->title }}" class="lazy">
                                    </div>
                                    <div class="date my-3">
                                        {{ date('d.m.Y.', strtotime($postSingle->created_at)) }}
                                    </div>
                                    <div class="blog__info d-flex flex-column justify-content-between">
                                        <h2 class="my-0">
                                            {{ $postSingle->title }}
                                        </h2>
                                        <div class="person d-flex align-items-center justify-content-start my-3">
                                            <div class="small-img-wrap mr-3">
                                                <img data-src="{{ $postSingle->team->image }}"
                                                    alt="{{ $postSingle->team->full_name }}" class="lazy">
                                            </div>
                                            <div class="person__details">
                                                <span class="name d-block">{{ $postSingle->team->full_name }}</span>
                                                <span class="position d-block">{{ $postSingle->team->position }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if ($posts->lastPage() > 1)
                    <div class="row front-pagination my-4 mb-sm-0">
                        <div class="col-12">
                            @if ($posts->lastPage() > 3)
                                <ul class="pagination list--reset">
                                    <li
                                        class="pagination__item pagination__item--prev {{ $posts->currentPage() == 1 ? ' disabled' : '' }}">
                                        <a class="button blue" href="{{ $posts->url(1) }}">
                                            <span>&#60;&#60;</span>
                                        </a>
                                    </li>
                                    @if ($posts->currentPage() >= 3)
                                        <li class="pagination__item disabled"><a class="button blue"
                                                href="{{ $posts->url(1) }}">
                                                <span>...</span>
                                            </a></li>
                                    @endif
                                    @if ($posts->currentPage() == 1)
                                        @for ($i = 1; $i <= $posts->currentPage() + 2; $i++)
                                            <li
                                                class="pagination__item {{ $posts->currentPage() == $i ? ' pagination__item--active disabled' : '' }}">
                                                <a class="button blue" href="{{ $posts->url($i) }}">
                                                    <span>{{ $i }}</span>
                                                </a>
                                            </li>
                                        @endfor
                                    @elseif ($posts->currentPage() == $posts->lastPage())
                                        @for ($i = $posts->currentPage() - 2; $i <= $posts->lastPage(); $i++)
                                            <li
                                                class="pagination__item {{ $posts->currentPage() == $i ? ' pagination__item--active disabled' : '' }}">
                                                <a class="button blue" href="{{ $posts->url($i) }}">
                                                    <span>{{ $i }}</span>
                                                </a>
                                            </li>
                                        @endfor
                                    @else
                                        @for ($i = $posts->currentPage() - 1; $i <= $posts->currentPage() + 1; $i++)
                                            <li
                                                class="pagination__item {{ $posts->currentPage() == $i ? ' pagination__item--active disabled' : '' }}">
                                                <a class="button blue" href="{{ $posts->url($i) }}">
                                                    <span>{{ $i }}</span>
                                                </a>
                                            </li>
                                        @endfor
                                    @endif

                                    @if ($posts->currentPage() <= $posts->lastPage() - 2 && $posts->lastPage() > 3)
                                        <li class="pagination__item disabled"><a class="button blue"
                                                href="{{ $posts->url(1) }}">
                                                <span>...</span>
                                            </a></li>
                                    @endif
                                    <li
                                        class="pagination__item pagination__item--next {{ $posts->currentPage() == $posts->lastPage() ? ' disabled' : '' }}">
                                        <a class="button blue" href="{{ $posts->url($posts->lastPage()) }}">
                                            <span>&#62;&#62;</span>
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <ul class="pagination list--reset">
                                    @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                        <li
                                            class="pagination__item {{ $posts->currentPage() == $i ? ' pagination__item--active disabled' : '' }}">
                                            <a class="button blue" href="{{ $posts->url($i) }}">
                                                <span>{{ $i }}</span>
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <h1 class="mb-4 my-sm-4 my-lg-5">
                    No posts yet <span class="smiley">: (</span>
                </h1>
            @endif
        </div>
    </section>
@endsection

@section('js')

@endsection
