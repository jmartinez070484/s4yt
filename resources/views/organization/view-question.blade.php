@extends('layouts.event')

@section('content')

@include('partials.nav')

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