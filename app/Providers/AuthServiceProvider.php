<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => 'App\Policies\DashboardPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerDashboardPolicies();
    }
    public function registerDashboardPolicies() {
        Gate::define('view-kurs', function($user) {
            return $user->hasAccess(['view-kurs']);
        });
        Gate::define('view-dashboard', function($user) {
            return $user->hasAccess(['view-dashboard']);
        });
        Gate::define('cek-dashboard', function($user) {
            return $user->hasAccess(['cek-dashboard']);
        });
        Gate::define('dashboard', function($user) {
            return $user->hasAccess(['dashboard']);
        });
    }
}
