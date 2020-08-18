@extends('layouts.organization')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>New Schedule Item</h1>
			<a href="{{ route('organization.schedule') }}">Back</a>
		</div>
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		<div class="fields">
			<form action="{{ route('organization.schedule.new') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Schedule Time</label>
					<input name="time" type="text" value="{{ $schedule -> time }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Schedule Content</label>
					<input name="text" type="text" value="{{ $schedule -> content }}" autocomplete="off" required />
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