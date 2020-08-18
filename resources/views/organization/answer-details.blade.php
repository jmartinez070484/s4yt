@extends('layouts.organization')

@section('content')

<div class="content form">
	<div class="container">
		<div class="labels">
			<h1>Answer</h1>
			@if(!$question -> answer_id)<a href="{{ route('organization.answers.details',['answer'=>$answer -> id]) }}" onclick="return answerWinner(this)">Select As Winner</a>@endif
			<p>Submited by: <br /><b>{{ $student -> first_name }} {{ $student -> last_name[0] }}<br />@if($grade = App\UserMeta::where('user_id',$student -> id) -> where('key','grade') -> first()) Grade {{ $grade -> value }} @endif @if($school = App\UserMeta::where('user_id',$student -> id) -> where('key','institution') -> first()) , {{ $school -> value }} @endif</b></p>
		</div>	
		@if(Request::input('success') == 1 && !$question -> answer_id)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		@if($question -> answer_id)
		<div class="success">
			<p>This is the winning answer!</p>
		</div>
		@endif
		<div class="fields">
			<form name="answer" action="{{ route('organization.answers.details',$answer -> id) }}" method="POST" autocomplete="off" onsubmit="return submitForm(this)" novalidate>
				<fieldset>
					<b>Score</b>
					<input id="score-1" name="score" type="radio" value="1" @if($answer -> score == 1) checked @endif @if($question -> answer_id) disabled @endif />
					<label for="score-1"></label>
					<input id="score-2" name="score" type="radio" value="2"  @if($answer -> score == 2) checked @endif @if($question -> answer_id) disabled @endif />
					<label for="score-2"></label>
					<input id="score-3" name="score" type="radio" value="3"  @if($answer -> score == 3) checked @endif @if($question -> answer_id) disabled @endif />
					<label for="score-3"></label>
				</fieldset>
				<fieldset>
					<label>Answer</label>
					<textarea name="question" readonly required>{{ $answer -> text }}</textarea>
				</fieldset>
				@if(!$question -> answer_id)
				<fieldset>
					@csrf
					<button>Save</button>
				</fieldset>
				@endif
			</form>
		</div>
	</div>
</div>

@endsection