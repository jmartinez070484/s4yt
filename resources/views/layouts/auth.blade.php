<!doctype html>
<html xml:lang="{{ app()->getLocale() }}" lang="{{ app()->getLocale() }}">
<head>
<title>S4YT</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- css stylesheets -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css2?family=Passero+One&display=swap" rel="stylesheet" type="text/css" />
<link href="//use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
@if($css = Helper::fileVersion('/css/app.css'))
<link href="{{ $css }}" rel="stylesheet" type="text/css" />
@endif

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
      
</head>
<body class="auth {{ $element ? $element : '' }}">

@yield('content')

@if($js = Helper::fileVersion('/js/app.js'))
<script src="{{ $js }}"></script>
@endif

</body>
</html>