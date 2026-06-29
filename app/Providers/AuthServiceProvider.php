<?php

namespace App\Providers;

use App\Models\Blueprint;
use App\Policies\BlueprintPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Blueprint::class => BlueprintPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
