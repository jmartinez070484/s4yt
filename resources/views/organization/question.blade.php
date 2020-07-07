@extends('layouts.organization')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Business Question</h1>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfully edited!</p>
		</div>
		@endif
		<div class="fields">
			<form name="question" action="{{ route('organization.question') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
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