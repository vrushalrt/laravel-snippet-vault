<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Comment $comment
    )
    {
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('laravel@basic.com',  'Laravel Basics'),
            subject: "Comment was Posted on your {$this->comment->commentable->title} post!"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.posts.commented',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attachment::fromPath('storage' . '/' . $this->comment->user->image->path)->as('profile.jpeg')->withMime('image/jpeg')
            // Attachment::fromStorageDisk('public', $this->comment->user->image->path)->as('profile.jpeg')->withMime('image/jpeg')
            // Attachment::fromData(fn () => Storage::get($this->comment->user->image->path), 'profile.jpeg')->as('profile.jpeg')->withMime('image/jpeg')
        ];
    }
}
