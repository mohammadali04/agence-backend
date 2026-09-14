<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\CarbonInterval;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        Passport::enablePasswordGrant();
//
//        Passport::tokensExpireIn(CarbonInterval::days(15));
//        Passport::refreshTokensExpireIn(CarbonInterval::days(30));
//        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));
    }
}
