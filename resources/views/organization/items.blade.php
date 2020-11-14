@extends('layouts.event')

@section('content')

<div class="items">
	<div class="container">
	    <div class="row	">
	    	<div class="col-12">
	    		<div class="btns">
	    			<ul>
						<li><a href="{{ route('organization.event') }}">Main Map</a></li>
						<li><a href="{{ route('organization.enterprise') }}">Business Map</a></li>
						<li><a href="{{ route('logout') }}">Exit</a></li>
					</ul>
	    		</div>
	    		<div class="note">
	            	<i onclick="removeNote(this)"></i>
	            	<strong>Do you know?</strong>
	            	<p>You can + <span></span> ?</p>
	            	<p>Just click on our <a href="#"></a> or <a href="#"></a></p>
	            	<p>And follow us or use one of our filters and tag us!</p>
	            </div> 
	    	</div>
	    	<div class="col-lg-6">
	    	</div>
	    	<div class="col-lg-6">
	    		{{ $items -> links() }}
	    	</div>
	    </div>
	    <div class="row">
	    	<div class="col-12">
	    		<div class="item-list">
		    		@foreach($items as $key => $item)
		            <div class="item" data-status="{{ $item -> status }}">
		            	<div class="item-preview">
			            	@if(Storage::disk('public') -> exists($item -> image))
			            	<div class="item-img">
			            		<img src="{{ Storage::disk('public') -> url($item -> image) }}" alt="{{ $item -> name }}" />
			            	</div>
			            	@endif
			            	@if($item -> tickets -> count())
			            	<div class="item-total">
			            		<span>{{ $item -> tickets -> count() }}</span>
			            	</div>
			            	@endif
			            </div>
			            @if($item -> status == 1)
		            	<div class="item-tickets">
		            		<strong>{{ $item -> name }}</strong>
			            </div>
			            @endif
		            </div>  
		            @endforeach
		        </div>     
	        </div>
	    </div>
	</div>
</div>

@endsection