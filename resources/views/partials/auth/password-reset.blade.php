<h1>Set your password</h1>
@if($validResetLink)
<form name="reset" action="{{ route('password.reset') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
    <fieldset>
        <label>Create a new password</label>
        <input name="password" type="password" autocomplete="off" required />
    </fieldset>
    <fieldset>
        <label>Reenter new password</label>
        <input name="password_confirmation" type="password" autocomplete="off" required />
    </fieldset>
    <fieldset>
        @csrf
        <input type="hidden" name="token" value="{{ $params['token'] }}" />
        <input type="hidden" name="email" value="{{ $params['email'] }}" />
        <input type="hidden" name="redirect" value="{{ route('login') }}" />
        <button>Set</button>
    </fieldset>
</form>
@else
<p>Invalid password reset link, please try again.<br /><br /><a href="{{ route('password.forgot') }}">I forgot my password</a></p>
@endif