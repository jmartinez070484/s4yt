@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>New Schedule Item</h1>
			<a href="{{ route('admin.business.schedule',$user -> id) }}">Back</a>
		</div>
		<div class="fields">
			<form action="{{ route('admin.business.schedule.new',$user -> id) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>Schedule Time</label>
					<input name="time" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Schedule Content</label>
					<input name="text" type="text" value="" autocomplete="off" required />
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