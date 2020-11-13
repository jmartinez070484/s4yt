@extends('layouts.event')

@section('content')

<div class="event">
	<div class="container">
	    <div class="row ">
	    	<div class="col-12">
		    	<div class="event-title">
		    		<h1>$4YT Treasure Map</h1>
		    	</div>
		    	<div class="event-btn">
		    		<a href="#" class="legend">Refresher where to go</a>
		    	</div>
		    	<div class="event-map">
		    		<a href="{{ route('items') }}" class="raffle"></a>
		    		<a href="{{ route('enterprise') }}" class="businesses"></a>
		    		<a href="{{ route('chatroom') }}" class="chat"></a>
		    		<a href="{{ route('winners') }}" class="winners"></a>
		    	</div>
		    </div>
	    </div>
	</div>
</div>

@endsection