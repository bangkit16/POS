<?php

namespace App\Providers;

use App\Models\UserModel;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Builder::useVite();

        Gate::define('admin', function (UserModel $user) {
            return $user->level_id == 1;
        });
        Gate::define('acc', function (UserModel $user) {
            return $user->status == 1;
        });
    }
}
