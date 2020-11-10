@extends('layouts.event')

@section('content')

<div class="container">
    <div class="row	">
    	<div class="col-12">
    		<img src="/assets/scholarship-winners.png" alt="" />
            <a href="{{ route('event') }}">Main Map</a>
    	</div>
    	@foreach($businesses as $business)
    	<div class="col-lg-6 col-md-6 col-12">
    		<div class="result">
    			<strong>{{ $business -> name }}</strong>
    			@if($scholarships = $business -> scholarships)
    			<ul>
    				@foreach($scholarships as $scholarship)
    					@if($scholarship -> user_id)
    				<li><span>${{ $scholarship -> amount }}</span> @if($student = $scholarship -> user) {{ $student -> first_name }} {{ $student -> last_name[0] }} @endif @if($grade = App\UserMeta::where('user_id',$student -> id) -> where('key','grade') -> first()) Grade {{ $grade -> value }} @endif @if($school = App\UserMeta::where('user_id',$student -> id) -> where('key','institution') -> first()) , {{ $school -> value }} @endif</li>
    					@endif
    				@endforeach
    			</ul>
    			@endif
    		</div>
    	</div>
    	@endforeach
    </div>
</div>

@endsection