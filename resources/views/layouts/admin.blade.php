<!doctype html>
<html xml:lang="{{ app()->getLocale() }}" lang="{{ app()->getLocale() }}">
<head>
<title>S4YT</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- css stylesheets -->
<link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css2?family=Muli:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" type="text/css" />
<link href="//use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
@if($css = Helper::fileVersion('/css/admin.css'))
<link href="{{ $css }}" rel="stylesheet" type="text/css" />
@endif

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
      
</head>
<body class="{{ Str::slug(Route::currentRouteName()) }}">

<header>

	<div class="container">
		<div class="logo">
			<h1>S4YT</h1>
		</div>
	</div>	

</header>

<main>  	

@yield('content')   

	<div class="sidebar">
		<ul>
			<li><a href="{{ route('admin') }}">Dashboard</a></li>
			<li><a href="{{ route('admin.students') }}">Students</a></li>
			<li><a href="{{ route('admin.business') }}">Businesses</a></li>
			<li><a href="{{ route('admin.items') }}">Items</a></li>
		</ul>
	</div>	

</main>

<div class="modal">
	<div class="row">
		<div class="content">

		</div>
	</div>
</div>

@if($js = Helper::fileVersion('/js/app.js'))
<script src="{{ $js }}"></script>
@endif

</body>
</html>