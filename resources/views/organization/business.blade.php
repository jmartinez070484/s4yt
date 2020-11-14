@extends('layouts.event')

@section('content')

<div class="nav">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul>
					<li><a href="{{ route('organization.event') }}">Main Map</a></li>
					<li><a href="{{ route('organization.enterprise') }}">Business Map</a></li>
					<li><a href="{{ route('logout') }}">Exit</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

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
				<div class="business-links">
					@if($question = $business -> question)
					<div class="question-link">
						<a href="{{ route('organization.self.question') }}">Explore the question...</a>
					</div>
					@endif
					<div class="connect-link">
						<a href="#" class="active">I’d love to connect with you<br />after the event!</a>
					</div>
				</div>
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