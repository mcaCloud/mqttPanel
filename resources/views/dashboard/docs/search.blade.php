@extends('layouts.videosTemplate')

@section('searchBar')

<!-- El COL y ROW lo hacemos para darle formato al titulo de lo que buscamos y 
	 el filtro de busqueda, sino se descuadra todo-->
<div class="container">		
	<div class="row">	

		<!--Vamos a saber lo que estamos buscando--->
		<div class=" col-md-4">
			<h2>Busqueda {{$search}}</h2>
		</div>	

	  	<div class="col-md-6" style="padding: 5px">
	  		<!-- Esta es una forma de poder ordenar y escojer que deseo seleccionar
				LE concatenamos el termino de la busqueda-->
			<form class="pull-left" action="{{url('/buscar/'.$search)}}" method="get">
				<label for="filter">Ordenar</label>
				<!-- FIlter es como se va a llamar el parametro que vamos a enviar al controlador-->
				<select name="filter" class="form-control">
					<option value="new">Mas nuevos primero</option>
					<option value="old">Mas antiguos primero</option>
					<option value="alfa">De la A a la Z</option>
				</select>
				<!-- Agrego la clase BTN-FILTER para poder separa un poco el boton del filtro-->
				<input type="submit" value="Ordenar" class="filter btn btn-sm btn-primary">
			</form>	
	  	</div>
	</div>
 </div>				
 @endsection 

<!-- Para mostrar los resultados de la busqueda no es necesario mucho
	solo llamar a videosList  para que nos lo despligue-->
 @section('videosList')  
 	@include('video.videosList')
 @endsection 

