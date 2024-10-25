<?php

namespace App\Models;

use App\Models\Scopes\DeletedAdminScope;
use App\Models\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes, Taggable;
    
    protected $fillable = ['title', 'content', 'user_id'];
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest(); // calling the local latest scope
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // E-338 Taggable Trait
    // public function tags()
    // {
    //     // return $this->belongsToMany(Tag::class)->withTimestamps();
    //     return $this->morphToMany(Tag::class, 'taggables')->withTimestamps();
    // }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {   
        // return with comment_count
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $this->latest()
            ->withCount('comments')
            ->with('user', 'tags');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        // Default scope
        // static::addGlobalScope(new LatestScope);

        // Admin delete scope
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        /**
         * When a blog post is deleted, delete all its comments.
         *
         * @param  \App\Models\BlogPost  $blogPost
         * @return void
         */
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
            // $blogPost->image()->delete();
            Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
        });
 
        static::updating(function(BlogPost $blogPost) {
            Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
        });
        
        static::restoring(function(BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }

}
