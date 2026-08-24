<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    \Modules\Home\Providers\HomeServiceProvider::class,
    \Modules\Blog\Providers\BlogServiceProvider::class,
    \Modules\Identity\Providers\IdentityServiceProvider::class,
    \Modules\Identity\Providers\SharedServiceProvider::class

];
