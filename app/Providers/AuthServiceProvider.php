<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //changes it
        //web admin-site
        Gate::define('admin-site', function($user){
            return($user->sebagai == "admin");
        });
        //web buyer-site
        Gate::define('buyer-site', function($user){
            return($user->sebagai == "buyer");
        });
    }
}
