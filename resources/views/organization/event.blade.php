@extends('layouts.event')

@section('content')

<div class="event">
	<div class="container">
	    <div class="row ">
	    	<div class="col-12">
		    	<div class="event-title">
		    		<h1>$4YT Treasure Map</h1>
		    	</div>
		    	<div class="event-map">
		    		<a href="{{ route('organization.items') }}" class="raffle"></a>
		    		<a href="{{ route('organization.enterprise') }}" class="businesses"></a>
		    	</div>
		    </div>
	    </div>
	</div>
</div>

@endsection