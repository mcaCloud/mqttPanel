<!DOCTYPE html>
<html lang="es">

<head>

	<title>Bienvenidos</title>

	@include('landingPage.common.headers')

	   <!--Esto lo coloco aqui para poder hacer PUSH de styles o scrips individuales en las vistas
        Es super poderoso para poder conbinar estilos en las vistas
        La vista que los ocupe solo tiene que hacer el PUSH y la RUTA-->
        @stack('styles')
        @stack('scripts')

</head>

<!-- Le pongo el id para que el boton de abajo me lleve a esta seccion-->
<!--Si el usuario llega abajo aparece el boton y me regresa arriba-->
<body id="page-top">

<!----------------WRAPPER----------------------------->
<!--Wrapper solo evita que se salgan los elementos del area-->
<!--The wrapper holds a design within certain boundaries.-->
<!-- no semantic meaning, it just puts a fence around the content. -->
<!--Container is generally used for structures that can contain more than one element. A wrapper, is something that wraps around a single object to provide more functionality and interface to it.-->
	<div id="wrapper">
		<!----------- CONTENEDOR --------------------->
		<!-- En daschboard.css podemos manipular el color de fondo-->
		<!-- d-flex significa la direccion del flex que ahora esta
			 seteada como columnas-->
		<div id="content-wrapper" class="d-flex flex-column">

			<div id="content">

				<div class="col-md-12 col-md-offset">
					@yield('topBar')
				</div>

				<!-- ---------MAIN-PAGE-CONTENT---------->				
				<div class="col-xs-12 col-md-offset col-md-8">
					@yield('tabs')	
					@yield('content')				
				</div>
				<!-- ---------/MAIN-PAGE-CONTENT---------->
				<div class="col-xs-12 col-md-4">	
					@yield ('sideBar')					
				</div>

			</div>


		</div>
		<!----------- /CONTENEDOR --------------------->

	</div><br>
<!---------------- /WRAPPER----------------------------->
    <!-- Scripts -->
    <!-- Este script es el que permite que el dropdown del topbar funcione. Sin el no va a funcionar-->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
				<footer >
					@include('landingPage.common.footer')
				</footer>
</html>