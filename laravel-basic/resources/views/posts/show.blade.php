@extends('layout.app')

@section('title', $post->title)

@section('content')

<div class="row">
    <div class="row">
        <div class="col-8">
            @if($post->image)
            <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed;">
                <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
            @else
                <h1>
            @endif

            {{ $post->title }}

            {{-- @if ((new carbon\Carbon())->diffInMinutes($post->created_at) < 60) --}}
                {{-- <span class="badge bg-success">New!</span> --}}
                {{-- @component('components.posts.badge', ['type' => 'success'])
                    New!
                @endcomponent --}}
                {{-- Own badge directive from AppServiceProvider --}}
                
                {{-- For Below laravel 8: Component alias --}}
                {{-- @badge('components.posts.badge', ['type' => 'success'])
                    New!
                @endbadge --}}

                {{-- For Above laravel 9 --}}
                <x-badge :data="['type' => 'success', 'show' => now()->diffInMinutes($post->created_at) < 60]"> 
                    New!
                </x-badge>

            {{-- @endif --}}
        @if($post->image)    
            </h1>
        </div>
        @else
            </h1>
        @endif

        <p>{{ $post->content }}</p>
        {{-- image --}}
        {{-- <img src="{{$post->image->url()}}" alt="{{ $post->title }}" class="img-fluid"> --}}
        
        <x-updated :data="['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name]" />
        <x-updated :data="['date' => $post->updated_at->diffForHumans()]" > Updated </x-updated>

        {{-- E-300 Tags --}}
        <x-tags :tags="$post->tags" />

        <p>Currently read by {{ $counter }} people.</p>

        <h4>Comments</h4>
        {{-- {{dd($post->comments)}}     --}}

        {{-- @include('comments._form') --}}
        <x-commentForm :route="route('posts.comments.store', ['post' => $post->id])" />
        
        {{-- E-331 OneToMany Polymorphic views --}}
        <x-commentList :comments="$post->comments" />

        {{-- @forelse ($post->comments as $comment )
            <p>{{ $comment->content }}</p>
            {{-- <p class="text-muted">added at {{ $comment->created_at->diffForHumans() }}</p> --}}
            {{-- <x-updated :data="['date' => $comment->created_at->diffForHumans(), 'name' => $comment->user->name]" /> --}}
        {{-- @empty --}}
            {{-- <p>No comments yet!</p> --}}
        {{-- @endforelse --}}
    
        {{-- @if (now()->diffInMinutes($post->updated_at) < 5)
            <div class="alert alert-info">New!</div>     
        @endif --}}

    </div>

    <div class="col-4">
        @include('posts._activity')
    </div>

</div>

@endsection