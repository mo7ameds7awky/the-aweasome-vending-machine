<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserRole;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('products_manage', static function(User $user, Product $product) {
            return $user->userRole->roleName === UserRole::ROLES['SELLER'] && $product->sellerId === $user->id;
        });
        Gate::define('products_create', static function(User $user) {
            return $user->userRole->roleName === UserRole::ROLES['SELLER'];
        });
    }
}
