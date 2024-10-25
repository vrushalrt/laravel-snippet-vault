<x-mail::message>
# Comment was posted on your blogpost.

Hi {{ $comment->commentable->user->name}},

Someone commented on your post

<x-mail::button :url="route('posts.show', ['post' => $comment->commentable->id])">
View the blog post
</x-mail::button>

<x-mail::button :url="route('users.show', ['user' => $comment->user->id])">
Visit {{ $comment->user->name }} Profile
</x-mail::button>

<x-mail::panel>
{{ $comment->content }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
