@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Student</h1>
		</div>	
		<div class="fields">
			<form action="{{ route('admin.students.new') }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<label>First Name</label>
					<input name="first_name" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Last Name</label>
					<input name="last_name" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Email Address</label>
					<input name="email" type="email" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<b>Details</b>
				</fieldset>
				<fieldset>
					<label>Institution</label>
					<input name="institution" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Grade</label>
					<input name="grade" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>Phone</label>
					<input name="phone" type="text" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>DOB</label>
					<input name="dob" type="date" value="" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>City/State</label>
					<input name="city_state" type="text" value="" autocomplete="off" required />
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