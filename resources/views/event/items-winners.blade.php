@extends('layouts.event')

@section('content')

<div class="results">
	<div class="container">
	    <div class="row	">
	    	<div class="col-12">
	    		<img src="/assets/treasure-winners.png" alt="" />
	    	</div>
	    	@foreach($items as $item)
	    	<div class="col-lg-4 col-md-4 col-12">
	    		<div class="item">
	            	<div class="item-preview">
		            	@if(Storage::disk('public') -> exists($item -> image))
		            	<div class="item-img">
		            		<img src="{{ Storage::disk('public') -> url($item -> image) }}" alt="{{ $item -> name }}" />
		            	</div>
		            	@endif
		            </div>
		            @if($user = $item -> winner)
		            <div class="item-winner">
		            	<p>{{ $user -> first_name }} {{ $user -> last_name[0] }}, @if($grade = App\UserMeta::where('user_id',$user -> id) -> where('key','grade') -> first()) Grade {{ $grade -> value }} @endif @if($school = App\UserMeta::where('user_id',$user -> id) -> where('key','institution') -> first()) , {{ $school -> value }} @endif</p>
		            </div>
		            @endif
	            </div> 
	    	</div>
	    	@endforeach
	    </div>
	</div>
</div>

@endsection