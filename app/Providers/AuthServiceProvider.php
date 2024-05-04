<?php

namespace App\Providers;

use App\carepays_providers\practise;
use App\carepays_providers\provider;
use App\Policies\providers\practisePolicy;
use App\Policies\providers\providerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        provider::class => providerPolicy::class,
        practise::class => practisePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function(provider $provider) {
            if($provider->hasRole('admin')) {
                return true;
            }
        });

    }
}
