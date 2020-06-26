@extends('dashboard.layout')
@section('title','Editar')
@section('content')
<p>
<!-- Esto es para que no nos pongo bullt points-->
	<ul style="list-style: none;">
	    <li>
	        <a href="{{route('dashboard::categorias.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
	        </a>
	        <span class="separador">| </span>
	        <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
	        </a> 
	    </li>  
	</ul>
</p>
<!-------------------------------------------------->
<!-------------------------------------------------->
<!-------------------------------------------------->
<div class="card shadow mb-6">
    <div class="card-header py-3">
    	<h3 class=" btn btn-info btn-lg"><strong>{{$product->name}}</strong></h3>
    </div>

	<div class="card-body">									
		<!-- ----FORMULARIO ----- -->
		<!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
		<!-- Tengo que pasarle en un array el cathegory ID-->
		<form action="{{route('dashboard::productos.update',['product_id'=>$product->id])}}" method="post" enctype="multipart/form-data" class="col-lg-7">
			<input type="hidden" name="_method" value="PUT">						
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
				<div class="form-group">
					<label for="title">Nombre del trámite</label>
						<!-- Para repoblar el formulario  como VALUE le imprimo la propiedad del objeto que deseo visualizar-->
						<input type="text" class="form-control" id="title" name="title" value="{{$product->name}}"/>
				</div>

				<!-- ----FORM-GROUPS ----- -->
				<div class="form-group">
					<label for="title">Descripción</label>
						<!-- Para repoblar el formulario  como VALUE le imprimo la propiedad del objeto que deseo visualizar-->
						<textarea class="form-control" id="description" name="description" value="{{$product->description}}">
							{{$product->description}}
						</textarea>
				</div>

				<button type="submit" class="btn btn-success">
					Modificar
				</button>
		</form>
	</div>
</div>
<!-- ----/FORMULARIO ----- -->
@endsection