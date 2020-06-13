	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="format-detection" content="telephone=no" />

  	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="{{ ENV('description') }}">
	<meta name="keywords" content="{{ ENV('keywords') }}">

  	<meta name="theme-color" content="#ffffff">
	<!-- Main style -->
	<link rel="stylesheet" href="{{ mix('/css/dashboard.css') }}">
	<link rel="stylesheet" href="{{ mix('/css/dashboard_resources.css') }}">

	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	
