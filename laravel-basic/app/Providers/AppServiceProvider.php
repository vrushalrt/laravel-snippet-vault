<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Blade::component('components.posts.badge', 'badge');
        Blade::component('components.posts.updated', 'updated');
        Blade::component('components.posts.card', 'card');
        Blade::component('components.posts.tags', 'tags');

        // E - 331 OneToMany Polymorphic view
        Blade::component('components.comment-form', 'commentForm');
        Blade::component('components.comment-list','commentList');
        
        // E - 306 Comments Errors
        Blade::component('components.errors', 'errors');

        // E-302 Blade View Composer
        // E-303 View Composer with blade

        // view()->composer('*', ActivityComposer::class);  // for inclding all views
        view()->composer(['posts.index', 'posts._activity'], ActivityComposer::class); 
    }
}
