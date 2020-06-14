@extends('dashboard.layout')

@section('content')
	<div class="col-md-12" style="padding: 10px">
		<div class="row">
			<h2>Editar {{$video->title}}</h1>

			<!-- HR es una separacion para que se vea mejor -->
			<hr>

			<!-- ----FORMULARIO ----- -->
			<!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
			<!-- Tengo que pasarle en un array el video ID-->
			<form action="{{route('dashboard::updateVideo',['video_id'=>$video->id])}}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
					<label for="title">Titulo</label>
					<!-- Para repoblar el formulario  como VALUE le imprimo la propiedad del objeto que deseo visualizar-->
					<input type="text" class="form-control" id="title" name="title" value="{{$video->title}}"/>
				</div>
<!----------------------------------------------------------------------------------------------->
				<div class="form-group">
					<label for="description">Descripcion</label>
					<textarea class="form-control" id="description" name="description">	{{$video->description}}
					</textarea> 
				</div>
<!----------------------------------------------------------------------------------------------->
				<div class="form-group">
					<label for="image">Miniatura</label><br/>
					<!--------MINIATURA----------------->
                    <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
                    @if(Storage::disk('images')->has($video->image))
                     <!-- Meto la imagen dentro de unos DIV para poder maquetarla de mejor manera
                     Ademas CREAR un fichero CSS en APP>PUBLIC para darle formato -->
                    <div class="video-image-thumb ">
                        <!--Le meto un video-image-mask para poder manipularla desde CSS-->
                        <div class="video-image-mask">
                             <!-- Le concateno a la ruta minitura la imagen que quiero ver, en este caso la que pertenesca al fichero que recibo por URL. Tambien le ponemos una clase para poder reducir su tamaño con CSS file-->
                             <img src="{{url('/miniaturaVideo/'.$video->image)}}" class="video-image" width="200px" />
                        </div>
                      </div>
                    @endif
					<input type="file" class="form-control" id="image" name="image"/>
				</div>
<!----------------------------------------------------------------------------------------------->
				<div class="form-group">
					<label for="video">Video</label><br/>
					<!------CARGAR EL VIDEO------>
					<!-- Esto es un etiqueta de HTML5-->
					<video controls id="video" width="200px" height="150px">
						<!-- SOURCE me va a buscar el video y cargarlo. Le pasamos el nombre de la ruta y como segundo parametro que nos llega por URL.
						Le pasamos el (video_path) que es la propieda donde esta guardada la ruta -->
						<source src="{{route('fileVideo', ['filename' => $video->video_path]) }}"></source>
						<!-- En caso de que no funcionde el source damos un mensaje de error-->
						Tu navegador no es compatible con HTML5
					</video>
					<input type="file" class="form-control" id="video" name="video"/>
				</div>
				<!-- ----/FORM-GROUPS ----- -->
<!----------------------------------------------------------------------------------------------->
				<button type="submit" class="btn btn-success">
					Modificar
				</button>
			</form>
			<!-- ----/FORMULARIO ----- -->
		</div>
	</div>
@endsection