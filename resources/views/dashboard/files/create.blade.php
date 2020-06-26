@extends('dashboard.layout')
@section('title','Requisitos')

@section('content')
<!------------------MAIN-CONTAINER----------------->
<!------------------------------>
<!----------OPTIONs------------->
<!------------------------------>
<p>
<!-- Esto es para que no nos pongo bullt points-->
  <ul style="list-style: none;">
    <li>
      <a href="{{route('dashboard::categorias.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
      </a>
      <span class="separador">| </span>
      <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
      </a> 
      <span class="separador">| </span>
      <a href="#" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Borrados
      </a> 
    </li>  
  </ul>
</p>
<!------------------------------>
<!----------OPTIONs------------->
<!------------------------------>
<div class="card shadow mb-6">

	<div class="card-body">
		<!-- ----FORMULARIO ----- -->
		<!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
		<form action="{{route('dashboard::archivos.store')}}" method="post" enctype="multipart/form-data" class="col-lg-7">
			<!-- Laravel nos obliga a proteger los formularios con CSRF-->
			{!! csrf_field() !!}

			<!----- MOSTRAR ERRORES------>

			@if($errors->any())
			<div class="alert alert-danger">
				<ul>
					<!-- Que recorra cada error y lo muestre en formato de lista. El idioma de los texto se cambia en CONFIG>APP.PHP. Pero necesito crear las carpetas de traducciones en la carpeta LANG -->

					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>				
			</div>
			@endif
			<!----- /MOSTRAR ERRORES------>

			<!-- ----FORM-GROUPS ----- -->
			<!-- Tengo que pasarle el Folder_ID-->	

			<input type="hidden" class="form-control" id="title" name="product" value="{{$productName->id}}" />

			<div class="form-group">
				<label for="title">Nombre para el documento</label>
				<input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" />
			</div>

			<div class="form-group">
				<!-- DOC es el ID que le tengo que pasar al controlador-->				
				<input type="file" class="form-control" id="doc" name="doc"/>
			</div>
			<!-- ----/FORM-GROUPS ----- -->

			<button type="submit" class="btn btn-success">
				CREAR
			</button>
		</form>
		<!-- ----/FORMULARIO ----- -->


</div>

	<!--------------/MAIN-ROW------------->
<!------------------/MAIN-CONTAINER----------------->
@endsection