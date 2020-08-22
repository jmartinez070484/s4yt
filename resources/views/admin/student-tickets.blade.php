@extends('layouts.admin')

@section('content')

<div class="content form">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>Student | Tickets</h1>
				<a href="{{ route('admin.students.tickets',['user'=>$user -> id]) }}" onclick="return addTicket(this)">Add Ticket</a>
				<p>Active tickets for: <b>{{ $user -> first_name }} {{ $user -> last_name }} | {{ $user -> email }}</b></p>
			</div>
			<div class="labels">
				<ul>
					<li>Id</li>
					<li>Status</li>
					<li>Actions</li>
				</ul>
			</div>
			<div class="items">
			@if(count($tickets) > 0)
				@foreach($tickets as $ticket)	
				<ul>
					<li>{{ $ticket -> id }}</li>
					@if($item = $ticket -> item)
					<li>Used on <b>{{ $item -> name }}</b></li>
					@else
					<li>Not Used</li>
					@endif
					<li><a href="{{ route('admin.delete.ticket',['user'=>$user -> id,'ticket'=>$ticket -> id]) }}" onclick="return deleteRecord(this);" data-message="Upon deleting, all data associated with this ticket will be lost"><i class="fa fa-times"></i></a></li>
				</ul>
				@endforeach
			@else
				<p>No Tickets</p>
			@endif
			</div>
		</div>
	</div>
</div>

@endsection