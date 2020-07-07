<h1>Welcome to S4YT!</h1>
<form name="login" action="{{ route('login') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
    <fieldset>
        <label>Email Address</label>
        <input name="email" type="email" autocomplete="off" required />
    </fieldset>
    <fieldset>
        <label>Password</label>
        <input name="password" type="password" autocomplete="off" required />
        <a href="{{ route('password.forgot') }}">Forgot Password?</a>
    </fieldset>
    <fieldset>
        @csrf
        <button>Sign in</button>
    </fieldset>
</form>