<div>
    <h2>Login {{ $guard }}</h2>
    <form action="{{ route('auth:'.$guard.'.store') }}" method="POST">
        @csrf
        <input type="text" name="email" id="email" >
        <input type="password" name="password" id="password">
        <button type="submit">Login</button>
    </form>
    {{-- @dump($message) --}}

    @error('error')
        {{ $message }}
    @enderror
</div>