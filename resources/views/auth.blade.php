@extends('layouts.auth')

@section('content')

<div class="container">
    <div class="row align-items-center">
        <div class="col-12">
            <div class="content">
                @include('partials.auth.'.$element)
            </div>
        </div>
    </div>
</div>

@endsection