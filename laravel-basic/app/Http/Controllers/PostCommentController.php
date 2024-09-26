<?php

namespace App\Http\Controllers;

use App\Events\CommentsEvent;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        CommentsEvent::dispatch($comment, 'CommentsPosted');

        session()->flash('status', 'Comment Added.');

        return redirect()->back();
    }
}
