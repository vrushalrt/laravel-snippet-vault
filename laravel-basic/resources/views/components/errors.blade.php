{{-- E-306 - Comments - Error Block --}}
@if ($errors->any())
    <div class="mt-3 mb-3">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-2 mt-2">
                {{ $error }}
            </div>                        
        @endforeach
    </div>
@endif