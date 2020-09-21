@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Business</h1>
		</div>	
		<div class="fields">
			<form name="business" action="{{ route('admin.business.new') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>First Name</label>
					<input name="first_name" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Last Name</label>
					<input name="last_name" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Email Address</label>
					<input name="email" type="email" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<b>Details</b>
				</fieldset>
				<fieldset>
					<label>Business Name</label>
					<input name="business" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Slug</label>
					<input name="slug" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Description</label>
					<textarea name="description" required=""></textarea>
				</fieldset>
				<fieldset>
					<label>Zoom Link</label>
					<input name="zoom_link" type="text" value="" autocomplete="off" />
				</fieldset>
				<fieldset>
					<label>Logo</label>
					<input name="logo" type="file" value="" onchange="filePreview(this)" autocomplete="off" required />
					<span onclick="this.previousElementSibling.click();"></span>
				</fieldset>
				<fieldset>
					<label>Icon</label>
					<input name="icon" type="file" value="" onchange="filePreview(this)" autocomplete="off" required />
					<span onclick="this.previousElementSibling.click();"></span>
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