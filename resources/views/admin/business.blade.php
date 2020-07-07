@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Business</h1>
			<a href="{{ route('admin.business.schedule',$user -> id) }}">Schedule</a>
			<a href="{{ route('admin.business.question',$user -> id) }}">Question</a>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfully edited!</p>
		</div>
		@endif
		@if(Request::input('success') == 2)
		<div class="success">
			<p>Successfully created!</p>
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
					<input name="business" type="text" value="{{ $business -> name }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Slug</label>
					<input name="slug" type="text" value="{{ $business -> slug }}" autocomplete="off" required />
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
					<input name="logo" type="file" value="" onchange="filePreview(this)" autocomplete="off" />
					<span @if($business -> logo) style="background:url('{{ Storage::disk('public') -> url($business -> logo) }}') no-repeat center center/contain #efefef;" @endif onclick="this.previousElementSibling.click();"></span>
				</fieldset>
				<fieldset>
					<label>Icon</label>
					<input name="icon" type="file" value="" onchange="filePreview(this)" autocomplete="off" />
					<span @if($business -> icon) style="background:url('{{ Storage::disk('public') -> url($business -> icon) }}') no-repeat center center/contain #efefef;" @endif onclick="this.previousElementSibling.click();"></span>
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