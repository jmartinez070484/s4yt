@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Business</h1>
			<a href="{{ route('admin.business.profile',$user -> id) }}">Back</a>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		<div class="fields">
			<form name="question" action="{{ route('admin.business.question',$user -> id) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Description</label>
					<textarea name="question" required>{{ $business -> question ? $business -> question -> text : null }}</textarea>
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