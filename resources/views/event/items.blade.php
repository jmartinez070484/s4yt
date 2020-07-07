@extends('layouts.event')

@section('content')

<div class="items">
	<div class="container">
	    <div class="row	">
	    	<div class="col-12">
	    		<div class="note">
	            	<i onclick="removeNote(this)"></i>
	            	<strong>Do you know?</strong>
	            	<p>You can earn up to 15 extra tix by sharing your experience in social media! Tag us now!</p>
	            </div> 
	    	</div>
	    	<div class="col-lg-6">
	    		<span>Your Total</span>
	    		<input name="tickets" type="number" value="{{ $user -> tickets -> count() }}" readonly />
	    	</div>
	    	<div class="col-lg-6">
	    		{{ $items -> links() }}
	    	</div>
	    </div>
	    <div class="row">
	    	<div class="col-12">
	    		@foreach($items as $key => $item)
	            <div class="item">
	            	<div class="item-preview">
		            	@if(Storage::disk('public') -> exists($item -> image))
		            	<img src="{{ Storage::disk('public') -> url($item -> image) }}" alt="{{ $item -> name }}" />
		            	@endif
		            </div>
	            	<div class="item-tickets">
		            	<form action="{{ route('items') }}/{{ $item -> id }}" method="POST" onsubmit="return false" novalidate>
		            		<input name="qty" type="number" min="0" max="100" value="{{ $item -> user_tickets -> count() }}" readonly />
			            	@csrf
			            	<i class="fa fa-caret-down"></i>
			            	<i class="fa fa-caret-up"></i>
			            </form>
		            </div>
	            </div>  
	            @endforeach     
	        </div>
	    </div>
	</div>
</div>

@endsection