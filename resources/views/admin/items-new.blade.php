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
					<label>Description</label>
					<textarea id="description" name="description"></textarea>
				</fieldset>
				<fieldset>
					<label>Image</label>
					<input name="image" type="file" value="" onchange="filePreview(this)" autocomplete="off" required />
					<div class="preview" onclick="this.previousElementSibling.click();"></div>
				</fieldset>
				<fieldset>
					@csrf
					<button>Save</button>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<script src="https://cdn.tiny.cloud/1/in4ryx80s3cj7g5nk85tgsrmk5yeo2wjjighym6tri0k477q/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
    	selector: '#description',
    	plugins: 'link',
		menubar: '',
		toolbar: 'link paragraph bold header'
    });
</script>

@endsection