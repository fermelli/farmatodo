<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-super-administrator', function (User $user) {
            return $user->isSuperAdministrator();
        });

        Gate::define('is-administrator', function (User $user) {
            return $user->isAdministrator();
        });

        Gate::define('is-super-administrator-or-administrator', function (User $user) {
            return $user->isSuperAdministrator() || $user->isAdministrator();
        });

        Gate::define('is-user', function (User $user) {
            return $user->isUser();
        });

        Gate::define('is-guest', function (User $user) {
            return $user->isGuest();
        });
    }
}
