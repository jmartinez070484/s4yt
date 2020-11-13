@extends('layouts.event')

@section('content')

<div class="items">
	<div class="container">
	    <div class="row	">
	    	<div class="col-12">
	    		<div class="btns">
	    			<ul>
						<li><a href="{{ route('event') }}">Main Map</a></li>
						<li><a href="{{ route('enterprise') }}">Business Map</a></li>
						<li><a href="{{ route('logout') }}">Exit</a></li>
					</ul>
	    		</div>
	    		<div class="note">
	            	<i onclick="removeNote(this)"></i>
	            	<strong>Do you know?</strong>
	            	<p>You can + <span></span> ?</p>
	            	<p>Just click on our <a href="https://www.facebook.com/ubuild.u" target="_BLANK"></a> or <a href="https://www.instagram.com/ubuild_u/" target="_BLANK"></a></p>
	            	<p>And follow us or use one of our filters and tag us!</p>
	            </div> 
	    	</div>
	    	<div class="col-lg-6">
	    		<span>Your Total</span>
	    		<input name="tickets" type="number" value="{{ $user -> tickets -> whereNull('item_id') -> count() }}" readonly />
	    	</div>
	    	<div class="col-lg-6">
	    		{{ $items -> links() }}
	    	</div>
	    </div>
	    <div class="row">
	    	<div class="col-12">
	    		@foreach($items as $key => $item)
	            <div class="item" data-status="{{ $item -> status }}">
	            	<div class="item-preview">
		            	@if(Storage::disk('public') -> exists($item -> image))
		            	<div class="item-img">
		            		<img src="{{ Storage::disk('public') -> url($item -> image) }}" alt="{{ $item -> name }}" />
		            	</div>
		            	@endif
		            	@if($item -> tickets -> count() > 0)
		            	<div class="item-total">
		            		<span>1</span>
		            	</div>
		            	@endif
		            </div>
		            @if($item -> status == 1)
	            	<div class="item-tickets">
	            		<strong>{{ $item -> name }}</strong>
	            		{!! $item -> description !!}
		            	<form action="{{ route('items') }}/{{ $item -> id }}" method="POST" onsubmit="return false" novalidate>
		            		<input name="qty" type="number" min="0" max="100" value="{{ $item -> user_tickets -> count() }}" readonly />
			            	@csrf
			            	<i class="fa fa-caret-down"></i>
			            	<i class="fa fa-caret-up"></i>
			            </form>
		            </div>
		            @endif
	            </div>  
	            @endforeach     
	        </div>
	    </div>
	</div>
</div>

@endsection