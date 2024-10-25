@extends('layout.app')

@section('content')

    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url(): '' }}" name="avatar" id="avatar" class="img-thumbnail avatar">
        </div>
        
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
            <x-commentForm :route="route('users.comments.store', ['user' => $user->id])" />
        
            <x-commentList :comments="$user->commentsOn" />
        </div> 

        
    </div>

@endsection