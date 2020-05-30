@extends('dashboard.layout')
@section('title','Panel de control')
@section('content')

<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	 <h1 class="h3 mb-0 text-gray-800">{{Auth::user()->completeName()}}</h1>
	 <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>



<div class="row">

	<div class="card col-md-8">
		<div class="card-header">
 			
 		</div>

 		<div class="card-body">
 			

 			
 		</div>
 	</div>

 	<div class="card col-md-4">

 		<div class="card-header">
 			Notificacion
 		</div>

 		<div class="card-body">

 			@foreach(Auth::user()->notifications as $notification)
 				<!--Llega el objeto JSON y lo decodifica para nosotros-->
 				
 				<!-- En caso de que salga el error de Undefined index verificamos 
 					que en las notificaciones los indices solicitados existen
 					Me paso que sabia que todo estaba bien pero seguia fallando
 					 Era que algunas notificaciones en la base de datos que habia enviado antes no tenia los campos de indice. Por eso no lo encontraba . Para ello comence a probar si llegaban y descubri que algunos indices no llegaban en algunas notiicaciones.
 					 Por eso el programa decia que no encontraba esos indices pero era solo en algunas notificaciones, por eso la pagina no podia cargar.
 					 Para probar utilizo el ISSET y verifico-->
 				<!--{{isset($notification->data['email'])}}-->

				<!-- Aqui trabajamos el icono de cada alerta-->
		          <a class="dropdown-item d-flex align-items-center" href="#">

		            <!-- Comparamos el tipo de notificacion que me ingresa
		                Y todas las de userDeleted me vendran con el siguinte icono-->
		            @if ($notification->type == 'App\Notifications\userDeleted')
		              <div class="mr-3">
		                <div class="icon-circle bg-danger">
		                  <i class="fas fa-exclamation-triangle text-white"></i>
		                  
		                </div>
		              </div>
		            @elseif ($notification->type == 'App\Notifications\userCreated')
		              <div class="mr-3">
		                <div class="icon-circle bg-success">
		                  <i class="fas fa-check-circle text-white"></i>
		                  
		                </div>
		              </div>
		            @elseif ($notification->type == 'App\Notifications\userUpdated')
		             <div class="mr-3">
		                <div class="icon-circle bg-primary">
		                  <i class="fas fa-user-edit text-white"></i>
		                  
		                </div>
		              </div>
		            @else
		            @endif

		            <div>
		              <div class="small text-gray-500"> Enviada {{$notification->created_at->diffForHumans()}}
		              </div>

		              {{$notification->data['name']}} ha sido {{$notification->data['action']}} 

		            </div>
		          </a>

 			@endforeach
 		</div>
  		
  	</div>

</div>

 

@stop
