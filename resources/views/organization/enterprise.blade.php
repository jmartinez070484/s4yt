@extends('layouts.event')

@section('content')

<div class="nav">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul>
					<li class="legend">Refresher on the X’s</li>
				</ul>
				<ul>
					<li><a href="{{ route('organization.event') }}">Main Map</a></li>
					<li><a href="{{ route('logout') }}">Exit</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-12">

		</div>
		@if(count($businesses) > 0 && $count = 1)
			@foreach($businesses as $business)
				@if($count++)
		<div class="col-lg-3 col-md-3 col-12 @if($count % 5 === 0 || $count === 8) right-details @endif" data-id="{{ $business -> id }}">
			<div class="item @if($business -> id === $organization -> id) self @endif" data-flag="{{ Arr::random([1,2,3,4]) }}">
				@if(Storage::disk('public') -> exists($business -> icon))
				<img src="{{ Storage::disk('public') -> url($business -> icon) }}" alt="{{ $business -> name }}" />
				@endif
				@if($question = $business -> question)
					@if($answer = $question -> user_answer)
				<span data-status="{{ $answer -> status }}"></span>
					@elseif($visit = App\Visit::where('business_id',$business -> id) -> where('user_id',Auth::id()) -> first())
				<span data-status="0"></span>
					@endif
				<span class="total">@if($total = App\Answer::where('question_id',$question -> id) -> count()) {{ $total }} @endif</span>
				@endif
				@if($business -> id === $organization -> id) <a href="{{ route('organization.self') }}"></a>@endif
			</div>
			<div class="item-details">
				<div class="item-details-img">
					@if(Storage::disk('public') -> exists($business -> icon))
					<img src="{{ Storage::disk('public') -> url($business -> icon) }}" alt="{{ $business -> name }}" />
					@endif
				</div>
				<div class="item-details-content">
					<strong>{{ $business -> name }}</strong>
					<p>{{ $business -> short_description }}</p>
				</div>
			</div>
		</div>
					@if($count === 7)
		<div class="col-lg-3 col-md-3 col-12">
			<div class="building-ship">

			</div>
		</div>
					@endif
				@endif
			@endforeach
		@endif
	</div>
</div>

@endsection