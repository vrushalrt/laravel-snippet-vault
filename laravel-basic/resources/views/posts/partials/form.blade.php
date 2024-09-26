<div class="form-group mb-2 mt-2">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" placeholder="Post Title" class="form-control" value="{{ old('title', optional($post ?? null)->title) }}">
</div>

{{-- @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror --}}

<div class="form-group mb-2 mt-2">
    <label for="content">Content</label>
    <textarea name="content" cols="30" rows="5" class="form-control" id="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

{{-- File --}}
<div class="form-group mb-2 mt-2">
    <label for="content">Thumbnail</label>
    <input type="file" name="thumbnail" id="thumbnail" placeholder="thumbnail" class="form-control-file" />
</div>


{{-- @error('content')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror --}}

{{-- Error Block --}}
{{-- @if ($errors->any())
    <div class="mb-3">
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>                        
            @endforeach
        </ul>
    </div>
@endif --}}

<x-errors />