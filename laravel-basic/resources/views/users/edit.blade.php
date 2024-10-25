@extends('layout.app')

@section('content')
    <form 
        action="{{ route('users.update', ['user' => $user->id]) }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="form-horizontal">

        @csrf
        @method('PUT')

        {{-- @include('users.partials.form') --}}

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url(): '' }}" class="img-thumbnail avatar">

                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload Image</h6>
                        <input type="file" name="avatar" id="avatar" class="form-control-file">
                    </div>
                </div>

            </div>
            
            <div class="col-8">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" value="{{ old('name', $user->name) }}" name="name" id="name">
                </div>

                <x-errors></x-errors>

                <div class="form-group mt-2">
                    <input type="submit" class="btn btn-primary" value="Save Chages">
                </div>
            </div> 
        </div>
        
    </form>
@endsection