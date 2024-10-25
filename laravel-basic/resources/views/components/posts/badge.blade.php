{{-- 
    This blade component displays a badge with the given text and optional type.
    The $show variable is used to optionally hide the badge.
    The default value of $show is true, so the badge is shown by default.
--}}

@if (!isset($data['show']) || $data['show'])
    {{-- <span class="badge bg-success"> --}}
    <span class="badge bg-{{ $data['type'] ?? 'success'}}">
        {{ $slot }}
    </span>    
@endif
