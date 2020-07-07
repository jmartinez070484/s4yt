@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Edit Item</h1>
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
					<label>Image</label>
					<input name="image" type="file" value="" onchange="filePreview(this)" autocomplete="off" />
					<span @if($item -> image) style="background:url('{{ Storage::disk('public') -> url($item -> image) }}') no-repeat center center/contain #efefef;" @endif onclick="this.previousElementSibling.click();"></span>
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