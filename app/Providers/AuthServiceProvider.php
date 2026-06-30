<?php

namespace App\Providers;

use App\Models\Blueprint;
use App\Policies\BlueprintPolicy;
use App\Models\RawContent;
use App\Policies\RawContentPolicy;
use App\Models\GeneratedPost;
use App\Policies\GeneratedPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Blueprint::class => BlueprintPolicy::class,
        RawContent::class => RawContentPolicy::class,
        GeneratedPost::class => GeneratedPostPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
