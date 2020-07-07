@extends('layouts.organization')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Answer</h1>
			<p>Submited by: <br /><b>{{ $student -> first_name }} {{ $student -> last_name }}</b>
			@foreach($metadata -> user as $meta)
			@endforeach
			</p>
		</div>	
		<div class="fields">
			<form name="answer" action="{{ route('organization.answers.details',$answer -> id) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Answer</label>
					<textarea name="question" required>{{ $answer -> text }}</textarea>
				</fieldset>
			</form>
		</div>
	</div>
</div>

@endsection