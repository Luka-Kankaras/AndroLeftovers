<header>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Forum MNE" />
            </a>
            <button class="navbar-toggler-btn d-lg-none" type="button" aria-label="Navbar toggler">
                <a href="#" class="menu example5" aria-label="Navbar toggler">
                    <span></span>
                </a>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto text-center">
                    <li class="nav-item d-flex align-items-center my-2 my-lg-0 mx-3">
                        <a href="{{ url('products') }}" class="nav-link {{ Route::is('products') ? 'active' : '' }}">
                            <span>{{ __('static.products') }}</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center my-2 my-lg-0 mx-3">
                        <a href="{{ url('about') }}" class="nav-link {{ Route::is('about') ? 'active' : '' }}">
                            <span>{{ __('static.about') }}</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center my-2 my-lg-0 mx-3">
                        <a href="{{ url('blog') }}"
                            class="nav-link {{ Route::is('blog') || Route::is('blog-single') ? 'active' : '' }}">
                            <span>{{ __('static.blog') }}</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center my-2 my-lg-0 mx-3">
                        <a href="{{ url('help') }}" class="nav-link {{ Route::is('help') ? 'active' : '' }}">
                            <span>{{ __('static.help') }}</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center  mx-auto mx-lg-0 ml-lg-3 my-2 my-lg-0">
                        <a href="https://shop.ivmax.com/" class="btn btn-primary btn__blue" target="_blank"
                            rel="noopener">
                            {{ __('static.shop') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
