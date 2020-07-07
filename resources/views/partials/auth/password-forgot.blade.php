<h1>Did you forget your password?</h1>
<p>Enter your email address you’re using for your account below <br />and we will send you a password reset link</p>
<form name="forgot" action="{{ route('password.forgot') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
    <fieldset>
        <label>Email Address</label>
        <input name="email" type="email" autocomplete="off" required />
    </fieldset>
    <fieldset>
        @csrf
        <button>Request Reset Link</button>
    </fieldset>
</form>
<a href="{{ route('login') }}">Back to Sign in</a>