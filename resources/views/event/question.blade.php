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
				<form action="{{ route('question',['business'=>$business -> slug]) }}" method="POST" autocomplete="off" novalidate>
					<fieldset>
					@if(!$answer || $answer -> status === 1)
						<input type="button" value="Save" />
						<input type="button" value="Discard" />
						<button>Submit</button>
						@csrf
					@else
						<button disabled>Answer has been Submitted</button>
					@endif
					</fieldset>
					<fieldset>
						<textarea name="answer" @if($answer && $answer -> status !== 1) readonly @endif required>{{ $answer ? $answer -> text : '' }}</textarea>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection