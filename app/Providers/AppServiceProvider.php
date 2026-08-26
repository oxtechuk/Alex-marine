<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        View::composer('layouts.app', function ($view) {
            try {
                if (Schema::hasTable('categories')) {
                    $navCategories = Category::where('is_active', true)
                        ->orderBy('sort_order')
                        ->get();
                    $view->with('navCategories', $navCategories);
                }
            } catch (\Throwable $e) {
                // Safe fallback during migrations or CLI
            }
        });
    }
}
