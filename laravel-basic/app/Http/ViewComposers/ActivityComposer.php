<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommentedPost = Cache::tags(['blog-post'])->remember('blog-post-most-commented', 60, function(){
            return BlogPost::mostCommented()->take(5)->get();        
        });  

        $mostActiveUsers = Cache::tags(['blog-post'])->remember('user-most-active', 60, function(){
            return User::withMostBlogPosts()->take(5)->get();        
        });  

        $mostActiveUserLastMonth = Cache::tags(['blog-post'])->remember('user-most-active-last-month', 60, function(){
            return User::withMostBlogPostsLastMonth()->take(5)->get();        
        });
        
        $view->with('mostCommented', $mostCommentedPost);
        $view->with('mostActive', $mostActiveUsers);
        $view->with('mostActiveUserLastMonth', $mostActiveUserLastMonth);
    }
}