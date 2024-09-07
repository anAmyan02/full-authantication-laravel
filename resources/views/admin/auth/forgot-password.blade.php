<form method="POST" action="{{ route('admin.password.email') }}">
    @csrf
    <div>
        <label for="email">Admin Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>
    <button type="submit">Send Password Reset Link</button>
</form>
