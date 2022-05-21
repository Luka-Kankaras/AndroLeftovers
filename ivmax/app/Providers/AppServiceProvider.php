<?php

namespace App\Providers;

use App\Models\Footer;
use App\Models\Homepage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.website', 'products', 'about', 'blog', 'help', 'welcome'], function ($view) {
            $homePageInfo = Homepage::query()->select('subtitle')->first();
            $footer = Footer::select('company_name', 'address', 'phone_number', 'email', 'terms_and_conditions', 'privacy_policy')->first();;
            $view->with(['homePageInfo' => $homePageInfo, 'footer' => $footer]);
        });
    }
}
