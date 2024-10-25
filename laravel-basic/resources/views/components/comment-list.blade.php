{{-- E-331 OneToMany Polymorphic views --}}

@forelse ($comments as $comment )
    <p>{{ $comment->content }}</p>
    {{-- <p class="text-muted">added at {{ $comment->created_at->diffForHumans() }}</p> --}}
    <x-tags :tags="$comment->tags" />
    <x-updated :data="['date' => $comment->created_at->diffForHumans(), 'name' => $comment->user->name, 'userId' => $comment->user->id]" />
@empty
    <p>No comments yet!</p>
@endforelse