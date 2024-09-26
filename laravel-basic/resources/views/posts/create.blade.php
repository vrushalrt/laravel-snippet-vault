@extends('layout.app')

@section('title', 'Create Post')

@section('content')

    <form action="{{ route('posts.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('posts.partials.form')
        <div>
            <input type="submit" value="Create" class="btn btn-primary mb-2">
        </div>
    </form>

@endsection