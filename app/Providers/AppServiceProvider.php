<?php

namespace App\Providers;

use App\Models\Link;
use App\Policies\LinkPolicy;
use App\Models\pageSettings;
use App\Policies\pageSettingsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Link::class => LinkPolicy::class,
        pageSettings::class => pageSettingsPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}