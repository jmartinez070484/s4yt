@extends('layouts.organization')

@section('content')


<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Profile</h1>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfully edited!</p>
		</div>
		@endif
		<div class="fields">
			<form name="edit-organization" action="{{ route('organization') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>First Name</label>
					<input name="first_name" type="text" value="{{ $user -> first_name }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Last Name</label>
					<input name="last_name" type="text" value="{{ $user -> last_name }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Email Address</label>
					<input name="email" type="email" value="{{ $user -> email }}" readonly autocomplete="off" required />
				</fieldset>
				<fieldset>
					<input id="change_password" type="checkbox" name="change_password" onchange="setPasswords(this)" value="1" />
					<label for="change_password">Change Password</label>
					<input name="password" type="password" value="" autocomplete="off" placeholder="Password" />
					<input name="password_confirmation" type="password" value="" placeholder="Confirm Password" autocomplete="off" />
				</fieldset>
				<fieldset>
					<b>Details</b>
				</fieldset>
				<fieldset>
					<label>Business Name</label>
					<input name="business" type="text" value="@if($business -> name){{ $business -> name }}@endif" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Slug</label>
					<input name="slug" type="text" value="{{ $business -> slug }}" readonly autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Description</label>
					<textarea name="description" required>{{ $business -> description }}</textarea>
				</fieldset>
				<fieldset>
					<label>Zoom Link</label>
					<input name="zoom_link" type="text" value="{{ $business -> zoom_link }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Logo</label>
					<div class="preview" @if($business -> logo) style="background:url('{{ Storage::disk('public') -> url($business -> logo) }}') no-repeat center center/contain #efefef;" @endif></div>
				</fieldset>
				<fieldset>
					<label>Icon</label>
					<div class="preview" @if($business -> icon) style="background:url('{{ Storage::disk('public') -> url($business -> icon) }}') no-repeat center center/contain #efefef;" @endif></div>
				</fieldset>
				<fieldset>
					@csrf
					<button>Save</button>
				</fieldset>
			</form>
		</div>
	</div>
</div>

@endsection