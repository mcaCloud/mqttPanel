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


<!-----------------------DATATABLES-ADITIONALS------------------------------------>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/r-2.2.5/sp-1.1.1/sl-1.3.1/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/r-2.2.5/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>

<!-- Esta es la libreria de jQUERY para que funcione las llamadas del MQTT-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
