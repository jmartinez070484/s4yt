@extends('layouts.admin')

@section('content')

<div class="content">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>Items</h1>
				<a href="{{ route('admin.items.new') }}">New</a>
			</div>
			<div class="labels four">
				<ul>
					<li>Id</li>
					<li>Name</li>
					<li>Image</li>
					<li>Actions</li>
				</ul>
			</div>
			<div class="items">
			@if(count($items) > 0)
				@foreach($items as $item)	
				<ul>
					<li>{{ $item -> id }}</li>
					<li>{{ $item -> name }}</li>
					<li>@if(Storage::disk('public') -> exists($item -> image))
		            	<img src="{{ Storage::disk('public') -> url($item -> image) }}" alt="{{ $item -> name }}" />
		            	@endif</li>
					<li><a href="{{ route('admin.items.details',$item -> id) }}"><i class="fas fa-pencil-alt"></i></a> <a href="{{ route('admin.delete.item',$item -> id) }}" onclick="return deleteRecord(this);"><i class="fa fa-times"></i></a></li>
				</ul>
				@endforeach
			@else
				<p>No Items</p>
			@endif
			</div>
		</div>
	</div>
</div>

@endsection