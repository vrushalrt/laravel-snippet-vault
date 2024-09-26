<?php

namespace App\Models;

use App\Models\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = ['content', 'blog_post_id', 'user_id']; 

    // public function blogPost()
    // {
    //     return $this->belongsTo(BlogPost::class);
    // }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // E-338 Taggable Trait
    // public function tags()
    // {
    //     return $this->morphToMany(Tag::class, 'taggables')->withTimestamps();
    // }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // Default scope
        // static::addGlobalScope(new LatestScope);
        // E-307 Route Model Binding
        static::creating(function(Comment $comment) {
            if ($comment->commentable_type === BlogPost::class) {
                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable->id}");
                Cache::tags(['blog-post'])->forget('mostCommented');
            }
        });
    }
}
