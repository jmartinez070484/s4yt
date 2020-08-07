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
		            @if($winner = $item -> ticket_winner())
		            <div class="item-winner">
		            	{!! $winner !!}
		            </div>
		            @endif
	            </div> 
	    	</div>
	    	@endforeach
	    </div>
	</div>
</div>

@endsection