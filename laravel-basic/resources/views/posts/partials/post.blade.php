    {{-- @continue($key == 1) --}}
    
    {{-- @if ($loop->even) --}}
        <h3>
    
            @if ($post->trashed())
                <del>
            @endif
                <a class="{{ $post->trashed() ? 'text-muted' : ''}}" href="{{ route('posts.show', $post->id) }}">
                {{ $post->title }}
            </a>
            @if ($post->trashed())
                </del>
            @endif

        </h3>

        {{-- Updated Component --}}
        <x-updated :data="['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name, 'userId' => $post->user->id]" />

        {{-- <p class="text-muted">
            Added at {{ $post->created_at->diffForHumans() }}
            by {{ $post->user->name }}
        </p> --}}

        {{-- E-300 Tags --}}
        <x-tags :tags="$post->tags" />

        @if ($post->comments_count)
            <p>{{ $post->comments_count }} comments</p>
            @else
            <p>No comments yet!</p>
        @endif
    {{-- @else
        <div style="background-color: silver">{{$key}}.{{ $post->title }}</div>
    @endif --}}

    <div class="mb-3">

        @can('update', $post)
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
        @endcan

        @cannot('delete', $post)
            <p>You cannot delete this post.</p>            
        @endcannot

        @if ($post->trashed())
            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            @endcan    
        @endif
        
    </div>
    
        {{-- @php $done = false @endphp

        @while (!$done)
            <div style="background-color: red">Pending</div>
            @php
                if (random_int( 1, $loop->count ) == $key) { 
                    $done = true;
                } 
            @endphp
        @endwhile --}}

    {{-- @break($key == 2) // Break loop if $key == 2 --}}
