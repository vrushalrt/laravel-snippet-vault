@extends('layout.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

{{--@section('styles')--}}
{{--    <style>--}}
{{--        .error-message {--}}
{{--            color: red;--}}
{{--            font-size: 0.8rem;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}

@section('content')

    <form method="POST"
          action="{{ isset($task) ? route('task.update', ['task' => $task->id]) : route('task.store') }} ">
        {{--        {{ $errors }}--}}
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="ttile">
                Title
            </label>
            <input type="text" name="title" id="title" @class(['border-red-500' => $errors->has('title')]) value="{{ $task->title ?? old('title') }}">
            @error('title')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description">Description</label>
            <textarea name="description" id="description" @class(['border-red-500' => $errors->has('description')]) rows="5">{{ $task->description ?? old('description') }}</textarea>
            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea name="long_description" id="long_description" @class(['border-red-500' => $errors->has('long_description')]) cols="30" rows="10">{{ $task->long_description ?? old('long_description') }}</textarea>
            @error('long_description')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex  items-center gap-2">
            <button type="submit" class="btn">
                @isset($task)
                    Update Task
                @else
                    Add Task
                @endisset
            </button>
            <a href="{{route('tasks.index')}}" class="link">Cancel</a>
        </div>

    </form>

@endsection
