@extends('layouts.organization')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Business Question</h1>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		<div class="fields">
			<form name="question" action="{{ route('organization.question') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Description</label>
					<textarea name="question" required>@if($question -> text){{ $question -> text }}@endif</textarea>
				</fieldset>
				@if($question -> status === 1)
				<fieldset>
					@csrf
					<button>Save</button>
				</fieldset>
				@endif
			</form>
		</div>
	</div>
</div>

@endsection