<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\User;
use App\Policies\BlogPostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //L269
        Gate::define('home.secret', function($user){
            return $user->is_admin;
        });
        
        // Gate::define('update-post', function($user, $post) {
        //     return $user->id == $post->user_id;
        // });
 
        // Gate::define('delete-post', function($user, $post) {
        //     return $user->id == $post->user_id;
        // });
  
        // Gate::define('posts.update', BlogPostPolicy::class . '@update');
        // Gate::define('posts.delete', BlogPostPolicy::class . '@delete');

        // Gate::resource('posts', BlogPostPolicy::class);
        // posts.create, posts.view, posts.update, post.delete

        Gate::before(function ($user, $ability) {
            if ($user->is_admin && in_array($ability, ['update','delete'])) {
                return true; 
            }
        });


        // Use Case: Log the activity of a user
        // Gate::after(function($user, $ability, $result){
        //     if ($user->is_admin) {
        //         return true;
        //     }
        // });
    }
}
