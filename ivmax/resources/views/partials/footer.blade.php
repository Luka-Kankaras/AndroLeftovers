<footer class="py-5 text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="logo__footer my-1">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/logo-white.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="contact-info py-5">
                    <a href="{{ url('/') }}" class="d-block my-1">
                        {{ $footer->company_name }}
                    </a>
                    <a href="https://maps.google.com/?q={{ $footer->address }}" class="d-block my-1" target="_blank"
                        rel="noopener">
                        {{ $footer->address }}
                    </a>
                    <a href="tel:{{ $footer->phone_number }}" class="d-block my-1">
                        {{ $footer->phone_number }}
                    </a>
                    <a href="mailto::{{ $footer->email }}" class="d-block my-1">
                        {{ $footer->email }}
                    </a>
                </div>
                <h1 class="small gold my-1 mb-3">
                    {{ __('static.subscribe_newsletter') }}
                </h1>
                <newsletters-form form_successful_submit="{{ __('static.form_successful_submit') }}">
                </newsletters-form>
                <div class="docs__links mt-5">
                    <a href="{{ $footer->terms_and_conditions }}" target="_blank" rel="noopener"
                        class="my-1">
                        {{ __('static.terms_and_conditions') }}
                    </a>
                    <span class="line mx-2">|</span>
                    <a href="{{ $footer->privacy_policy }}" target="_blank" rel="noopener"
                        class="my-1">
                        {{ __('static.privacy_policy') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
