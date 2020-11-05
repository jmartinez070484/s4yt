@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Edit Item</h1>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		<div class="fields">
			<form name="item" action="{{ route('admin.items.details',['item'=>$item -> id]) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Name</label>
					<input name="name" type="text" value="{{ $item -> name }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Slug</label>
					<input name="slug" type="text" value="{{ $item -> slug }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Description</label>
					<textarea id="description" name="description">{{ $item -> description }}</textarea>
				</fieldset>
				<fieldset>
					<label>Image</label>
					<input name="image" type="file" value="" onchange="filePreview(this)" autocomplete="off" />
					<div class="preview" @if($item -> image) style="background:url('{{ Storage::disk('public') -> url($item -> image) }}') no-repeat center center/contain #efefef;" @endif onclick="this.previousElementSibling.click();"></div>
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
		toolbar: 'link paragraph bold header',
		setup: function (editor) {
            editor.on('change',function(e){
            	editor.save();
            });
        }
    });
</script>

@endsection