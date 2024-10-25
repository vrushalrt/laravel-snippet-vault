{{-- E-306 - Comments Form --}}
<div class="mb-2 mt-2">
@auth
    <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" rows="2" class="form-control" id="content"></textarea>
            <x-errors />
        </div>

        <div class="mb-2 mt-2">
            <button type="submit" class="btn btn-primary btn-block">Add Comment</button>
        </div>
    </form>
    @else
    <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login to Add Comment</a>
@endauth
</div>
<hr>