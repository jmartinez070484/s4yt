@extends('layouts.organization')

@section('content')

<div class="content">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>Scholarships</h1>
			</div>
			<div class="labels four">
				<ul>
					<li>Id</li>
					<li>Name</li>
					<li>Amount</li>
					<li>Winner</li>
				</ul>
			</div>
			<div class="items">
			@if(count($scholarships) > 0)
				@foreach($scholarships as $scholarship)	
				<ul>
					<li>{{ $scholarship -> id }}</li>
					<li>{{ $scholarship -> name }}</li>
					<li>${{ $scholarship -> amount }}</li>
					<li>@if($user = $scholarship -> user) {{ $user -> first_name }} {{ $user -> last_name }} @if($answer = $scholarship -> answer) | <a href="{{ route('organization.answers.details',['answer'=>$answer -> id]) }}" target="_BLANK" class="link">Answer</a> @endif @else N/A @endif</li>
				</ul>
				@endforeach
			@else
				<p>No records</p>
			@endif
			</div>
		</div>
	</div>
</div>

@endsection