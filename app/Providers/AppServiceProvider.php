<?php

namespace App\Providers;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Pdf::class, function ($app) {
            return new Pdf($app['config']->get('hermes.pdftotext_bin'));
        });
    }
}
