@extends('layouts.event')

@section('content')

@include('partials.nav')

<div class="container">
    <div class="row ">
    	<div class="col-12">
	    	
	    </div>
	    <div class="col-12">
	    	<div class="title">
	    		<h1>Student Chat Room</h1>
	    	</div>
	    	<div class="chat-app">
	    		<script type="text/javascript">function add_chatinline(){var hccid=51983991;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);} add_chatinline(); </script>
	    	</div>
	    </div>
    </div>
</div>

@endsection