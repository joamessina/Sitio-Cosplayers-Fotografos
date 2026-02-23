<?php

namespace App\Providers;

use App\Mail\ResendTransport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;

class ResendServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->make(MailManager::class)->extend('resend', function () {
            return new ResendTransport();
        });
    }
}