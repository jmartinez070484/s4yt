@extends('layouts.admin')

@section('content')

<div class="content">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>Business Scholarships</h1>
				<a href="{{ route('admin.business.profile',$user -> id) }}">Back</a>
			</div>
			<div class="labels four">
				<ul>
					<li>Id</li>
					<li>Name</li>
					<li>Amount</li>
					<li>Winner</li>
				</ul>
			</div>
			<div class="items">
			@if(count($scholarships) > 0)
				@foreach($scholarships as $scholarship)	
				<ul>
					<li>{{ $scholarship -> id }}</li>
					<li>{{ $scholarship -> name }}</li>
					<li>${{ $scholarship -> amount }}</li>
					<li>@if($scholarship -> user_id) @else N/A @endif</li>
				</ul>
				@endforeach
			@else
				<p>No records</p>
			@endif
			</div>
		</div>
	</div>
</div>

@endsection