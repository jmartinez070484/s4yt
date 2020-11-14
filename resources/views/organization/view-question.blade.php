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
				<div class="text">
					<p><b>Q:</b> {{ $question -> text }}</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="answer">
				<form action="{{ route('organization.self.question') }}" method="POST" autocomplete="off" novalidate>
					<fieldset>
						<textarea name="answer" required></textarea>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection