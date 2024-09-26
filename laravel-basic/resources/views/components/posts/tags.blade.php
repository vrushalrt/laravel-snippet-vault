<p>
    @foreach ($tags as $tag )

        <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}" class="text-decoration-none">
            <span class="badge bg-success badge-lg">{{ $tag->name }}</span>
        </a>

    @endforeach
</p>