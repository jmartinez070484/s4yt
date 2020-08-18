@extends('layouts.admin')

@section('content')

<div class="content">
	<div class="container">
		<div class="list">
			<div class="title">
				<h1>{{ $type }}</h1>
				<a href="{{ route('admin.'.$type.'.new') }}">New</a>
				<form action="{{ Request::url() }}" method="GET" autocomplete="off" novalidate>
					<fieldset>
						<input type="search" name="q" value="{{ Request::input('q') }}" placeholder="Search by name or email..." autocomplete="off" required />
					</fieldset>
				</form>
			</div>
			<div class="labels">
				<ul>
					<li>Name</li>
					<li>Email</li>
					<li>Actions</li>
				</ul>
			</div>
			<div class="items">
			@if(count($users) > 0)
				@foreach($users as $user)	
				<ul>
					<li>{{ $user -> first_name }} {{ $user -> last_name }}</li>
					<li>{{ $user -> email }}</li>
					<li><a href="{{ route('admin.'.$type.'.profile',$user -> id) }}"><i class="fas fa-pencil-alt"></i></a> <a href="{{ route('admin.delete.user',$user -> id) }}" onclick="return deleteRecord(this);"><i class="fa fa-times"></i></a></li>
				</ul>
				@endforeach
			@else
				<p>No records</p>
			@endif
			</div>
			@if(count($users) > 0)
			<div class="pagination">
				{{ $users -> links() }}
			</div>
			@endif
		</div>
	</div>
</div>

@endsection