@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Student</h1><a href="{{ route('admin.students.tickets',['user'=>$user -> id]) }}">View Student Tickets</a>
		</div>	
		@if(Request::input('success') == 1)
		<div class="success">
			<p>Successfull!</p>
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
					<label>Preferred Email Address</label>
					<input name="preferred_email" type="email" value="@if($preferredEmail = App\UserMeta::where('user_id',$user -> id) -> where('key','preferred_email') -> first()){{ $preferredEmail -> value }}@endif" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<b>Details</b>
				</fieldset>
				<fieldset>
					<label>Institution</label>
					<input name="institution" type="text" value="@if($institution = App\UserMeta::where('user_id',$user -> id) -> where('key','institution') -> first()){{ $institution -> value }}@endif" autocomplete="off" />
				</fieldset>
				<fieldset>
					<label>Grade</label>
					<input name="grade" type="text" value="@if($grade = App\UserMeta::where('user_id',$user -> id) -> where('key','grade') -> first()){{ $grade -> value }}@endif" autocomplete="off" />
				</fieldset>
				<fieldset>
					<label>Phone</label>
					<input name="phone" type="text" value="@if($phone = App\UserMeta::where('user_id',$user -> id) -> where('key','phone') -> first()){{ $phone -> value }}@endif" autocomplete="off" required />
				</fieldset>
				<fieldset>
					<label>DOB</label>
					<input name="dob" type="date" value="@if($dob = App\UserMeta::where('user_id',$user -> id) -> where('key','dob') -> first()){{ $dob -> value }}@endif" autocomplete="off" />
				</fieldset>
				<fieldset>
					<label>City/State</label>
					<input name="city_state" type="text" value="@if($city_state = App\UserMeta::where('user_id',$user -> id) -> where('key','city_state') -> first()){{ $city_state -> value }}@endif" autocomplete="off" required />
				</fieldset>
				<fieldset>
					@csrf
					<button>Save</button>
					<input type="button" onclick="return sendWelcomeEmail(this)" value="Send Welcome Email" />
				</fieldset>
			</form>
		</div>
	</div>
</div>

@endsection