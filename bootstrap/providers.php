<?php

use Illuminate\Pagination\Paginator;
use App\Providers\AppServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    Paginator::useBootstrap(),
];
