@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Business</h1>
			<a href="{{ route('admin.business.schedule',$user -> id) }}">Schedule</a>
			<a href="{{ route('admin.business.question',$user -> id) }}">Question</a>
			<a href="{{ route('admin.business.scholarships',$user -> id) }}">Scholarships</a>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		<div class="fields">
			<form name="edit-business" action="{{ route('admin.business.profile',$user -> id	) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
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
					<input name="email" type="email" value="{{ $user -> email }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<b>Details</b>
				</fieldset>
				<fieldset>
					<label>Business Name</label>
					<input name="business" type="text" value="@if(isset($business -> name)){{ $business -> name }}@endif" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Slug</label>
					<input name="slug" type="text" value="@if(isset($business -> slug)){{ $business -> slug }}@endif" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Description</label>
					<textarea name="description" required>@if(isset($business -> description)){{ $business -> description }}@endif</textarea>
				</fieldset>
				<fieldset>
					<label>Zoom Link</label>
					<input name="zoom_link" type="text" value="@if(isset($business -> zoom_link)){{ $business -> zoom_link }}@endif" autocomplete="off" />
				</fieldset>
				<fieldset>
					<label>Logo</label>
					<input name="logo" type="file" value="" onchange="filePreview(this)" autocomplete="off" />
					<span @if(isset($business -> logo)) style="background:url('{{ Storage::disk('public') -> url($business -> logo) }}') no-repeat center center/contain #efefef;" @endif onclick="this.previousElementSibling.click();"></span>
				</fieldset>
				<fieldset>
					<label>Icon</label>
					<input name="icon" type="file" value="" onchange="filePreview(this)" autocomplete="off" />
					<span @if(isset($business -> icon)) style="background:url('{{ Storage::disk('public') -> url($business -> icon) }}') no-repeat center center/contain #efefef;" @endif onclick="this.previousElementSibling.click();"></span>
				</fieldset>
				<fieldset>
					@csrf
					<button>Save</button>
					<input type="button" onclick="return sendWelcomeEmail(this)" value="Send Welcome Email" />
				</fieldset>
			</form>
		</div>
	</div>
</div>

@endsection