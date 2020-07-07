@extends('layouts.admin')

@section('content')

<div class="content">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>Business Schedule</h1>
				<a href="{{ route('admin.business.schedule.new',$user -> id) }}">Add New</a>
				<a href="{{ route('admin.business.profile',$user -> id) }}">Back</a>
			</div>
			<div class="labels four">
				<ul>
					<li>Id</li>
					<li>Time</li>
					<li>Text</li>
					<li>Actions</li>
				</ul>
			</div>
			<div class="items">
			@if(count($schedule) > 0)
				@foreach($schedule as $item)	
				<ul>
					<li>{{ $item -> id }}</li>
					<li>{{ $item -> time }}</li>
					<li>{{ $item -> content }}</li>
					<li><a href="{{ route('admin.business.schedule.item',['user'=>$user -> id,'schedule'=>$item -> id]) }}"><i class="fas fa-pencil-alt"></i></a> <a href="{{ route('admin.business.schedule.item',['user'=>$user -> id,'schedule'=>$item -> id]) }}" onclick="return deleteRecord(this);"><i class="fa fa-times"></i></a></li>
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