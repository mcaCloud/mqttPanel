<!DOCTYPE html>
<html lang="es">

<head>

	<title>@yield('title')</title>

	@include('dashboard.common.header')

	

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

		<!--Este es el sidebar-->
		<!--Aqui el side bar esta fuera del contenedor principal-->
		<!--POr eso ocupa todo el lateral-->
		@include('dashboard.common.navbar')

		<!----------- CONTENEDOR --------------------->
		<!-- En daschboard.css podemos manipular el color de fondo-->
		<!-- d-flex significa la direccion del flex que ahora esta
			 seteada como columnas-->
		<div id="content-wrapper" class="d-flex flex-column">

			<div id="content">

				@include('dashboard.common.topbar')

				<!--Use .container for a responsive fixed width container.
					Use .container-fluid for a full width container, spanning the entire width of your viewport.-->
				<!--El contenedor es responsive pero necesito trabajar los
					contenidos ya que algunos nose visualizan bien-->
				<!--Despues es necesario pasasr la applicacion a un app -->

				<div class="container-fluid">

					@stack('styles')
					
					@yield('content')
				</div>

			</div>

		</div>
		<!----------- /CONTENEDOR --------------------->

	</div>
<!---------------- /WRAPPER----------------------------->

	<!-- Este boton me regresa a arriba en la pagina-->
	<!-- Le asigne el ID top-page al body para poder regresar-->
	<!-- Se lo paso como parametro al href-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>



  	<script src="{{ mix('/js/dashboard.js') }}"></script>
  	<script src="{{ mix('/js/dashboard_resources.js') }}"></script>

	@include('dashboard.common.message')

  	@yield('js-validation')
  	@yield('js-scripts')

<!---------------- JS  --------------------------------->
<script type="text/javascript">

	/*Función de jQuery ready(), su funcionalidad es la de ejecutar funciones una vez cargada en su totalidad una página web (DOM)
	 *document especifica el DOM de la web actual. Parámetro su valor debe ser ‘document’
	 *funcion (Obligatorio): Función a ejecutarse.
	 *().ready(funcion) no se recomienda 
	*/
	$(document).ready(function() {

		/*************************** 1 **********************/
		/*Esto es para presentar la base de datos
		 * #datatable-responsive es un OBJETO. El ID que llevaran todas las 
		 BD que interactuan con esta funcion.
		 *En todas las vista la tabla lleva este ID
		 */
		$('#datatable-responsive').DataTable({

			/*DOM(Document Object Model)*/
			/*With the HTML DOM, JavaScript can access 
			 and change all the elements of an HTML document
			 *When a web page is loaded, the browser creates a Document Object Model of the page..*/

			 /*Lleva la letra de donde donde el elemento
			 va a aparecer en el orden del documento.
			 *The built-in table control elements in DataTables are:

				l - length changing input control
				f - filtering input
				t - The table!
				i - Table information summary
				p - pagination control
				r - processing display element
			*/
			dom: 't',

			/*Replace a DataTable which matches the given selector
			/*En este caso el OBJETO es el ID #datatable-responsive
			/*La reemplaza con la nueva BD que tiene el ID del OBJETO
			*/
			bDestroy: true,

			/*Aqui se maneja los mensajes que aparecen en la interface
			de la tabla. Se puede costumizar y poner mensajes en otros
			idiomas.
			*/
			language: {
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Último",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
							  },
				"oAria": {
					"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						  }
			},pageLength: 10
		});
		/*************************** /1 **********************/

		/*************************** 2 **********************/
		/*Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options.
		/*https://select2.org/  */

		/*Esto es para los dropdown menues donde se tiene que seleccionar una
		opcion.

		/*Select2 was designed to be a replacement for the standard <select> box that is displayed by the browser. By default it supports all options and operations that are available in a standard select box, but with added flexibility.

		/*Select2 can take a regular select box y le da un formato muy lindo
		Select2 will register itself as a jQuery function if you use any of the distribution builds, so you can call .select2() on any jQuery selector where you would like to initialize Select2.

		*/
		$(".select2").css({width:'100%'}).select2({
			/*When set to true, causes a clear button ("x" icon) to appear on the select box when a value is selected. Clicking the clear button will clear the selected value, effectively resetting the select box back to its placeholder value.*/
			allowClear: true,
			/*The placeholder value will be displayed until a selection is made.
			*The most common situation is to use a string of text as your placeholder value.
			*/
			placeholder: {
				/*Alternatively, the value of the placeholder option can be a data object representing a default selection (<option>). In this case the id of the data object should match the value of the corresponding default selection.*/
				id: '',
				/*Este es el texto que aparece en la caja*/
				text: 'Seleccione una opción...'
			},

			minimumResultsForSearch: 6
		});
		/*************************** /2 **********************/

		/*************************** 3 **********************/
		/*The blur event occurs when an element loses focus.
		 *The blur() method triggers the blur event, or attaches a function to run when a blur event occurs.
		 *This method is often used together with the focus() method.
		 *Esto aun no lo entiendo bien
		 */
		$('#name').blur(function(event){
			$.get('/dashboard/common/slug/'+$('#name').val(), function(data){
				$('#slug').val(data);
			});
		});
		/*************************** /3 **********************/

		/*************************** 4 **********************/
		$('#display_name').blur(function(event){
			$.get('/dashboard/common/slug/'+$('#display_name').val(), function(data){
					$('#name').val(data);
			});
		});
		/*************************** /4 **********************/
	});
</script>
<!---------------- JS  --------------------------------->

</body>

</html>
