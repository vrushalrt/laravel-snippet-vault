<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function blogPosts()
    {
        return $this->morphedByMany(BlogPost::class, 'taggables')->withTimestamps()->as('tagged');
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'taggables')->withTimestamps()->as('tagged');
    }
}
