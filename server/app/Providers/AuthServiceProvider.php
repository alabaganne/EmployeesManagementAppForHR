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

        Gate::before(function(\App\Models\User $user) {
            if($user->isAdmin()) {
                return true;
            }
        });
        
        Gate::define('view-collaborator', 'App\Policies\CollaboratorPolicy@index');
        Gate::define('view-profile', 'App\Policies\CollaboratorPolicy@show');
        Gate::define('add-collaborator', 'App\Policies\CollaboratorPolicy@store');
        Gate::define('edit-collaborator', 'App\Policies\CollaboratorPolicy@update');
        Gate::define('delete-collaborator', 'App\Policies\CollaboratorPolicy@destroy');
    }
}
