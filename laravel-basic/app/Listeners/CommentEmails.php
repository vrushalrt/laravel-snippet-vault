<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Events\CommentsEvent;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use InvalidArgumentException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CommentEmails
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentsEvent $event): void
    {
        match ($event->action) {
            CommentsEvent::COMMENT_POSTED => $this->handleSendCommentPostedEmail($event->comment),

            default => throw new InvalidArgumentException('Invalid job event action.')
        };
    }

    public function handleSendCommentPostedEmail($comment): void
    {
        // Send email
        Mail::to($comment->user->email)->send(
            // new CommentPosted($comment)
            new CommentPostedMarkdown($comment)
        );
    }
}
