@extends('layouts.organization')

@section('content')

<div class="content form" data-scholarships='{!! $scholarships !!}'>
	<div class="container">
		<div class="labels">
			<h1>Answer</h1>
			<a href="#" onclick="return answerWinner(this)" data-url="{{ route('admin.partials',['element'=>'select-winner']) }}">Select As Winner</a>
			<p>Submited by: <br /><b>{{ $student -> first_name }} {{ $student -> last_name[0] }}<br />@if($grade = App\UserMeta::where('user_id',$student -> id) -> where('key','grade') -> first()) Grade {{ $grade -> value }} @endif @if($school = App\UserMeta::where('user_id',$student -> id) -> where('key','institution') -> first()) , {{ $school -> value }} @endif</b></p>
		</div>	
		@if(Request::input('success') == 1 && !$question -> answer_id)
		<div class="success">
			<p>Successfull!</p>
		</div>
		@endif
		@if($answerScholarship)
		<div class="success">
			<p>This is the winning answer! - ${{ $answerScholarship -> amount }} Scholarship</p>
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
				@if(!$answerScholarship)
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