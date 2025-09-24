<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Policy mappings.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Task::class => \App\Policies\TaskPolicy::class,
    ];

    /**
     * Bootstrap any authentication / authorization services.
     */
    public function boot(): void
    {
        // Policies are registered from the $policies array.
    }
}
