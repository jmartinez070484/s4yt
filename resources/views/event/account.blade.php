@extends('layouts.event')

@section('content')

<div class="container">
    <div class="row	">
    	<div class="col-12">
    	</div>
    	<div class="col-12">
    		<div class="cart-label">
    			<strong>Questions you've submitted your ideas on:</strong>
    		</div>
            <div class="cart-answers">
            @if(count($answers) > 0 )
                @foreach($answers as $answer)
                    @if($question = $answer -> question)
                        @if($business = $question -> business)
                <div class="item" data-flag="{{ Arr::random([1,2,3,4]) }}">
                    @if(Storage::disk('public') -> exists($business -> icon))
                    <img src="{{ Storage::disk('public') -> url($business -> icon) }}" alt="{{ $business -> name }}" />
                    @endif
                    <span data-status="{{ $answer -> status }}"></span>
                    <a href="{{ route('question',['business'=>$business -> slug]) }}"></a>
                </div>
                        @endif
                    @endif
                @endforeach
            @endif
            </div>
    		<div class="cart-label">
    			<strong>Treasure Items you've bid on:</strong>
    		</div>
    		<div class="cart-items">
    		@if(count($collection) > 0	)
    			@foreach($collection as $group)
                    @if($ticket = $group -> first())
                        @if($item = $ticket -> item)
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
                        @endif
                    @endif
    			@endforeach
    		@endif
    		</div>
    	</div>	
    </div>
</div>

@endsection