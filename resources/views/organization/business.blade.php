@extends('layouts.event')

@section('content')

@include('partials.nav')

<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-12">
				@if(Storage::disk('public') -> exists($business -> logo))
				<div class="logo">
					<img src="{{ Storage::disk('public') -> url($business -> logo) }}" alt="{{ $business -> name }}" />
				</div>
				@endif
				<div class="text">
					<h1>{{ $business -> name }}</h1>
					<p>{{ $business -> description }}</p>
				</div>
				@if($question = $business -> question)
				<div class="question-link">
					<a href="{{ route('organization.self.question') }}">Explore the question...</a>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

@if($business -> zoom_link)
<div class="zoom">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<a href="{{ $business -> zoom_link }}" target="_BLANK">Enter Zoom Room</a>
			</div>
		</div>
	</div>
</div>
@endif

@if($business -> youtube)
<div class="schedule">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="yt-video">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $business -> youtube }}" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@if($business -> schedule)
<!--div class="schedule">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Zoom Speaker Schedule</h2>
				@foreach($business -> schedule as $schedule)
				<ul>
					<li>{{ $schedule -> time }}</li>
					<li>{{ $schedule -> content }}</li>
				</ul>
				@endforeach
			</div>
		</div>
	</div>
</div-->
@endif

@endsection