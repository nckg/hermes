<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\PdfToText\Pdf;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
