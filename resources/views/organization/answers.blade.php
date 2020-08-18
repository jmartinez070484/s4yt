@extends('layouts.organization')

@section('content')

<div class="content">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>Student Answers</h1>
			</div>
			@if($question -> answer_id)
			<div class="items winner">
				<ul class="selected">
					<li>{{ $winner -> user -> first_name }} {{ $winner -> user -> last_name }}</li>
					<li>{{ Carbon::parse($winner -> created_at) -> format('m/d/y - g:ia') }}</li>
					<li><a href="{{ route('organization.answers.details',$winner -> id) }}"><i class="fas fa-binoculars"></i></a></li>
				</ul>
			</div>
			@endif
			<div class="labels four">
				<ul>
					<li>Student</li>
					<li>Date/Time</li>
					<li>Score</li>
					<li>Actions</li>
				</ul>
			</div>
			<div class="items">
			@if(count($answers) > 0)
				@foreach($answers as $answer)	
				<ul>
					<li>{{ $answer -> user -> first_name }} {{ $answer -> user -> last_name }}</li>
					<li>{{ Carbon::parse($answer -> created_at) -> format('m/d/y - g:ia') }}</li>
					<li data-score="{{ $answer -> score }}"></li>
					<li><a href="{{ route('organization.answers.details',$answer -> id) }}"><i class="fas fa-binoculars"></i></a></li>
				</ul>
				@endforeach
			@else
				<p>No records</p>
			@endif
			</div>
			@if(count($answers) > 0)
			<div class="pagination">
				{{ $answers -> links() }}
			</div>
			@endif
		</div>
	</div>
</div>

@endsection