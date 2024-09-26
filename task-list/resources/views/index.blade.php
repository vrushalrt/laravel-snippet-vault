@extends('layout.app')

{{--Title Section--}}
@section('title', 'The List of Tasks')

{{--<div>--}}
{{--    Hello blade template!--}}
{{--</div>--}}

{{--@isset($name)--}}
{{--    <div>--}}
{{--        The name is : {{ $name }}--}}
{{--    </div>--}}
{{--@endisset--}}

{{--<h1>The lists of Tasks.</h1>--}}

{{--<div>--}}
{{--    @if(count($tasks))--}}
{{--        @foreach($tasks as $task)--}}
{{--            <div>{{ $task->title }}</div>--}}
{{--        @endforeach--}}
{{--    @else--}}
{{--    <div>There are no tasks!</div>--}}
{{--    @endif--}}

{{--    alternative foreach loop--}}

{{--Content Section--}}
@section('content')
    <nav class="mb-4">
        <a href="{{ route('tasks.create') }}" class="link">Add Task!</a>
    </nav>

    @forelse($tasks as $task)
    {{--    <div>{{ $task->title }}</div>--}}
        <div>
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}" @class(['line-through' => $task->completed])> {{ $task->title }} </a>
        </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse

    @if($tasks->count())
        <nav class="mb-4">
            {{ $tasks->links() }}
        </nav>
    @endif

@endsection

{{--</div>--}}
