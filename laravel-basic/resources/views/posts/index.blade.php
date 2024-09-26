@extends('layout.app')

@section('title', 'Blog Posts')

@section('content')

{{-- @if(count($posts) > 0)
    @foreach ($posts as $key => $post)
        <div>{{$key}}.{{ $post['title'] }}</div>
    @endforeach
@else
No post found!
@endif --}}

{{-- @each('posts.partials.post', $posts, 'post') --}}

<div class="row">
    <div class="col-8">
        @auth
            @forelse ($posts as $key => $post)
                @include('posts.partials.post')
            @empty
                No post found!
            @endforelse
        @endauth
    </div>
    
    <div class="col-4">
        @include('posts._activity')
    </div>

</div>

@endsection
