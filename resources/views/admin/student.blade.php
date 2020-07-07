@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Student</h1><a href="{{ route('admin.students.tickets',['user'=>$user -> id]) }}">View Student Tickets</a>
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
			<form action="{{ route('admin.students.profile',['user'=>$user -> id]) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>First Name</label>
					<input name="first_name" type="text" value="{{ $user -> first_name }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Last Name</label>
					<input name="last_name" type="text" value="{{ $user -> last_name }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Email Address</label>
					<input name="email" type="email" value="{{ $user -> email }}" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<b>Details</b>
				</fieldset>
				@if($fields = $user -> metadata)
					@foreach($fields as $field)
				<fieldset>
					<label>{{ $field -> name }}</label>
					<input name="{{ $field -> key }}" type="text" value="{{ $field -> value }}" autocomplete="off" required />
				</fieldset>
					@endforeach
				@endif
				<fieldset>
					@csrf
					<button>Save</button>
				</fieldset>
			</form>
		</div>
	</div>
</div>

@endsection