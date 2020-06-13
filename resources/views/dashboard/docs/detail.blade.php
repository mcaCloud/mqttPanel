@extends('landingPage.layout')


@section('topBar')
	@include('landingPage.topBar')
@endsection


@section('sideBar')
	@include('landingPage.common.sideBars.home')
@endsection
@section('content')

<div class="row">
    <div class="col-md-12" style="padding: 10px">
		<div><h2>{{$video->title}}</h2>
			<hr>
			<div class="col-md-12">
				<!------CARGAR EL VIDEO------>
				<!-- Esto es un etiqueta de HTML5-->
				<video controls="" id="video-player">
					<!-- SOURCE me va a buscar el video y cargarlo. Le pasamos el nombre de la ruta y como segundo parametro que nos llega por URL.
					Le pasamos el (video_path) que es la propieda donde esta guardada la ruta -->
					<source src="{{route('fileVideo', ['filename' => $video->video_path]) }}"></source>
					<!-- En caso de que no funcionde el source damos un mensaje de error-->
					Tu navegador no es compatible con HTML5
				</video>
				<!------ DESCRIPCION DEL VIDEO------>
				<div class="panel panel-success video-data ">
					<div class="panel-heading class">
						<div class="panel-title">
							<!-- Aqui voy a utilizar un helper para poder formatear las fechas. Utilizo el helper y el metodo dentro del helper, y finalmente le paso mi fecha para formatear-->
							Subido por <strong><a href="{{route('channel',['user_id'=>$video->user_id])}}">{{$video->user->alias}}</a></strong> {{$video->created_at->diffForHumans()}}
						</div>
					</div>
					<div class="panel-body">
						{{$video->description}}
					</div>
				</div>

				<!------VIDEO   ------>
				<!--Para los comentario aprovecha la funcion de INCLUDE y lo hago aparte para que no sea pesado el codigo todo en la misma pagina-->
				<!-- Solo se meustran los comentarios a los usuarios identificados -->

				@include('dashboard.videos.comments')
			</div>
		</div>
	</div>
</div>
@endsection