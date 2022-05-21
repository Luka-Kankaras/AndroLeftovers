@php $assetVersion = 'v0.1'; @endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('meta')
    <title>@yield('title', 'ivmax')</title>

    <link rel="preload" href="/assets/fonts/Sora-Bold.ttf" as="font" crossorigin="anonymous" />
    <link rel="preload" href="/assets/fonts/Sora-Light.ttf" as="font" crossorigin="anonymous" />
    <link rel="preload" href="/assets/fonts/Sora-Regular.ttf" as="font" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('static/css/owl.carousel.min.css') }}?version={{ $assetVersion }} }}">
    <link rel="stylesheet" href="{{ asset('static/css/slider.css') }}?version={{ $assetVersion }} }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="canonical" href="{{ env('APP_URL') }}">

    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>

    {{-- Facebook Pixel Code --}}
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1661231254036961');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1661231254036961&ev=PageView&noscript=1" />
    </noscript>
    {{-- End Facebook Pixel Code --}}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HBBVCLH41Y"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-HBBVCLH41Y');
    </script>
</head>

<body>
    <div id="app">
        @if (App::environment(env('ENABLE_REGION_MODAL')) && (!isset($_COOKIE['regionChosen']) || $_COOKIE['regionChosen'] != true) && !Route::is('welcome'))
            @include('partials.select-region')
        @else
            @if (!isset($header_show))
                @include('partials.header')
            @endif

            <main class="main">
                @yield('content')
            </main>

            @if (!isset($footer_show))
                @include('partials.footer')
            @endif
        @endif

    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}?version={{ $assetVersion }}"></script>
    <script src="{{ mix('js/scripts.js') }}?version={{ $assetVersion }}"></script>
    <script src="{{ asset('static/js/jquery-3.3.1.min.js') }}?version={{ $assetVersion }}">
    </script>
    <script src="{{ asset('static/js/yall.min.js') }}?version={{ $assetVersion }}"></script>
    <script src="{{ asset('static/js/owl.carousel.js') }}?version={{ $assetVersion }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            yall({
                observeChanges: true,
            });
        });
    </script>

    @yield('js')
</body>

</html>
