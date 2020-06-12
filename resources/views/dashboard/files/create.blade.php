@extends('dashboard.layout')
@section('title','Crear documento')

@section('content')
<!------------------MAIN-CONTAINER----------------->

<div class="card shadow mb-6">
	
 	<div class="card-header py-3">
		<h2>{{ $folderName->name }}</h1>
	</div>	

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

			<div class="form-group">
				<label for="title"><strong>Crea aquí un nuevo documento</strong></label>
			</div>

			<input type="hidden" class="form-control" id="title" name="folder" value="{{$folderName->id}}" />

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