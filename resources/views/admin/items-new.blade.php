@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>New Item</h1>
		</div>	
		<div class="fields">
			<form name="item" action="{{ route('admin.items.new') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Name</label>
					<input name="name" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Slug</label>
					<input name="slug" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Image</label>
					<input name="image" type="file" value="" onchange="filePreview(this)" autocomplete="off" required />
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