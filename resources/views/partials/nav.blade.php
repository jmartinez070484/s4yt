<div class="nav">
	<div class="container">
		<div class="row">
			<div class="col-12">
				@if(Route::currentRouteName() === 'question')
				<ul>
					<li><a href="{{ route('business',['business'=>$business->slug]) }}">Back</a></li>
				</ul>
				@endif
				<ul>
					<li><a href="{{ route('event') }}">Main Map</a></li>
					<li><a href="{{ route('enterprise') }}">Business Map</a></li>
					<li><a href="{{ route('logout') }}">Exit</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>