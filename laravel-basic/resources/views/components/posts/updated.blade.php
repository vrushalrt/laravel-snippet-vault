<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $data['date'] }}
    
    @if(isset($data['name']))

        @if (isset($data['userId']))
            by <a href="{{ route('users.show', ['user' => $data['userId']] ) }}" >{{ $data['name'] }}</a>
        @endif

        by {{ $data['name'] }}
    @endif
</p>