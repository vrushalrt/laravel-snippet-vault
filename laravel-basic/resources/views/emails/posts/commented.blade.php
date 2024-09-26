<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<p>
    Hi {{ $comment->commentable->user->name}},
</p>

<p>
    Someone commented on your post
    <a href="{{ route('posts.show', ['post' => $comment->commentable->id])}}">
        {{ $comment->commentable->title }}
    </a>
</p>

<hr>

<p>
    {{-- <img src="{{ $message->embed($comment->user->image->url()) }}"/> --}}
    <img src="{{ $message->embed('storage/' . $comment->user->image->path) }}"/>
    {{-- <img src="{{ $message->embed($comment->user->image->url()) }}"/> --}}
    <a href="{{ route('users.show', ['user' => $comment->user->id])}}">
        {{ $comment->user->name }}
    </a>Said:
</p>

<p>
    "{{ $comment->content }}"
</p>