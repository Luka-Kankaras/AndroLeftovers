@extends('layouts.website')

@section('title')
    {{ $postSingle->title }}
@endsection

@section('meta')

    {{-- Primary Meta Tags --}}
    <meta name="title" content="{{ $postSingle->title }}">
    <meta name="description" content='{!! preg_replace('/(<.+?>|<.+|<)/', '', $postSingle->text) !!}'>
    <meta name="keywords" content="ivmax, ivmax®, cetkica, četkica, tootbrush, toothpaste">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ivmax® - Blog">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $postSingle->title }}">
    <meta name="author" content="ivmax®">
    <meta property="og:description" content='{!! preg_replace('/(<.+?>|<.+|<)/', '', $postSingle->text) !!}'>
    <meta property="og:image" content="{{ asset($postSingle->thumbnail) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $postSingle->title }}">
    <meta property="twitter:description" content='{!! preg_replace('/(<.+?>|<.+|<)/', '', $postSingle->text) !!}'>
    <meta property="twitter:image" content="{{ asset($postSingle->thumbnail) }}">
    <meta property="twitter:image:width" content="1200">
    <meta property="twitter:image:height" content="628">

@endsection

@section('content')
    <section class="section__blogs single__blog section__top pt-4 pb-5 py-sm-5">
        <div class="container">
            <div class="date text-center my-3 my-lg-0 mb-lg-4">
                {{ date('d.m.Y.', strtotime($postSingle->created_at)) }} | {{ $postSingle->time_to_read }} min read
            </div>
            <h1 class="small text-center my-4">
                {{ $postSingle->title }}
            </h1>
            <div class="blog__cover__wrapper d-block mx-sm-auto my-5">
                <img data-src="{{ asset($postSingle->thumbnail) }}" class="lazy blog__cover"
                    alt="{{ $postSingle->title }}">
            </div>
            <div class="person">
                <div class="small-img-wrap mb-3">
                    <img data-src="{{ $postSingle->team->image }}" alt="{{ $postSingle->team->full_name }}"
                        class="lazy">
                </div>
                <div class="person__details">
                    <span class="name d-block">{{ $postSingle->team->full_name }}</span>
                    <span class="position d-block">{{ $postSingle->team->position }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12 position-relative">
                    <div class="blog__circle__1"></div>
                    <div class="blog__content">
                        {!! $postSingle->text !!}
                    </div>
                    <div class="line my-5"></div>
                    <div class="social__share d-flex align-items-center">
                        <span class="mr-3">{{ __('static.share') }}</span>
                        <a class="mr-3" onclick="shareFb('{{ url()->current() }}')">
                            <img data-src="{{ asset('assets/images/social-share/fb.svg') }}" alt="Facebook Share"
                                class="lazy">
                        </a>
                        <a class="mr-3" onclick="shareTw('{{ url()->current() }}')">
                            <img data-src="{{ asset('assets/images/social-share/tw.svg') }}" alt="Twitter Share"
                                class="lazy">
                        </a>
                        <a class="mr-3" onclick="shareLn('{{ url()->current() }}')">
                            <img data-src="{{ asset('assets/images/social-share/ln.svg') }}" alt="Linkedin Share"
                                class="lazy">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (count($postSingle->similarPosts()) > 0)
        <section class="section__blogs mt-0 pt-4 py-sm-5">
            <div class="container">
                <h1 class="small text-center d-block mb-3">
                    {{ __('static.similar_blogs') }}
                </h1>
                <div class="row position-relative">
                    <div class="blog__circle__2"></div>
                    @foreach ($postSingle->similarPosts() as $postSimilar)
                        <div class="blog__card col-12 col-lg-6 my-4">
                            <a href="{{ url('blog-single/' . $postSimilar->id) }}">
                                <div class="img-wrap">
                                    <img data-src="{{ asset($postSimilar->thumbnail) }}"
                                        alt="{{ $postSimilar->title }}" class="lazy">
                                </div>
                                <div class="date my-3">
                                    {{ date('d.m.Y.', strtotime($postSimilar->created_at)) }}
                                </div>
                                <div class="blog__info d-flex flex-column justify-content-between">
                                    <h2 class="my-0">
                                        {{ $postSimilar->title }}
                                    </h2>
                                    <div class="person d-flex align-items-center justify-content-start my-3">
                                        <div class="small-img-wrap mr-3">
                                            <img data-src="{{ $postSimilar->team->image }}"
                                                alt="{{ $postSimilar->team->full_name }}" class="lazy">
                                        </div>
                                        <div class="person__details">
                                            <span class="name d-block">{{ $postSimilar->team->full_name }}</span>
                                            <span class="position d-block">{{ $postSimilar->team->position }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('js')
    <script>
        const shareFb = (thisRoute) => {
            window.open("https://www.facebook.com/sharer/sharer.php?u=" + thisRoute);
        };

        const shareTw = (thisRoute) => {
            window.open("https://twitter.com/intent/tweet?url=" + thisRoute + "&text=");
        };

        const shareLn = (thisRoute) => {
            window.open(
                "http://www.linkedin.com/shareArticle?mini=true&url=" + thisRoute
            );
        };
    </script>
@endsection
