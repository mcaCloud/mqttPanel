@extends('dashboard.layout')
@section('title','Notificaciones')

@section('content')
<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-5">

  <!-------------------------------------->
  <!--------- Header---------------------->
  <div class="card-header py-3">

    <!------12COL------------->
    <div class="row col-12">
        
      <div class="col">  
        <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">

        @if(Auth::user()->unreadNotifications->count())
            <!-- Trabajar la connectividad a los mensajes
                 Ahora esta de manera estatica-->
            <button type="button" class="btn btn-primary">Sin leer<span class="badge">{{Auth::user()->unreadNotifications->count()}}</span></button>
             
        @else
        	No tienes notificaciones nuevas.
        @endif
         </h6>
      </div>

      <div class="span">
        <!-- Utilizo el metodo CREATE del controlador de User-->
        <a href="{{route('emptyNotifications')}}" class="btn btn-danger btn-icon-split float-left">
          <!-- Le meto un simbolo de +, con una luminosidad del 50%-->
          <span class="icon text-white-50">
            <i class="fas fa-folder-minus"></i>
          </span>

          <span class="text">Vaciar</span>
        </a>
      </div>
      
    </div>
    <!------12COL------------->

  </div>
  <!--------- Header---------------------->
  <!-------------------------------------->

<!--/////////////////////////////////////////////////////////-->
  <!-------------BODY--------------------->
  <div class="card-body">
    <div>

<!---------------------Table------------------->
      <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
      <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
      <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">

        <tbody>
            <!--Aqui tomo la variable ('details') que cree en el metodo Index
                del controloador de User-->
            @foreach ($notification as $index => $item)

              <!--***** TR *****-->
              <tr>
                <!--Me recorre cada uno de los resultados-->
<!-- TD 1--------------------------------------------------------->
                <td>

                <!-- En caso de que salga el error de Undefined index verificamos 
		          que en las notificaciones los indices solicitados existen
		          Me paso que sabia que todo estaba bien pero seguia fallando
		           Era que algunas notificaciones en la base de datos que habia enviado antes no tenia los campos de indice. Por eso no lo encontraba . Para ello comence a probar si llegaban y descubri que algunos indices no llegaban en algunas notiicaciones.
		           Por eso el programa decia que no encontraba esos indices pero era solo en algunas notificaciones, por eso la pagina no podia cargar.
		           Para probar utilizo el ISSET y verifico-->
		        <!--isset($notification->data['email'])-->
		          <!-- Aqui trabajamos el icono de cada alerta-->
		          <!-- Le metemos un background para diferenciar las no leidas de las leidas-->
		 			<!----------------------------------------------->
					@if (!is_null($item->read_at))

			          <a class="dropdown-item d-flex align-items-center" href="{{route('notificationDetail',[$item->id])}}"vstyle="background-color: #F3F3EF ">


			         @else
			          <a class="dropdown-item d-flex align-items-center" href="{{route('notificationDetail',[$item->id])}}" style="background-color: lightgray ">

			            
		         	@endif
					<!-- Comparamos el tipo de notificacion que me ingresa
			           Y todas las de userDeleted me vendran con el siguinte icono-->
		<!----------------------------------------------->

		            @if ($item->type == 'App\Notifications\userDeleted')
		              <div class="mr-3">
		                <div class="icon-circle bg-danger">
		                  <i class="fas fa-exclamation-triangle text-white"></i>
		                  
		                </div>
		              </div>
		            @elseif ($item->type == 'App\Notifications\userCreated')
		              <div class="mr-3">
		                <div class="icon-circle bg-success">
		                  <i class="fas fa-check-circle text-white"></i>
		                  
		                </div>
		              </div>
		            @elseif ($item->type == 'App\Notifications\userUpdated')
		             <div class="mr-3">
		                <div class="icon-circle bg-primary">
		                  <i class="fas fa-user-edit text-white"></i>
		                  
		                </div>
		              </div>
		            @else
		            @endif
		<!----------------------------------------------->

				   <div id="flip">
		              <div class="small text-white"> 
		                	<strong style="text-shadow: 2px 2px 8px #323231">	
		                 		Enviada {{$item->created_at->diffForHumans()}}
		                	</strong>  		                              
		              </div>

		              {{$item->data['subject']}} 
		            </div>

                </td>
<!-- TD 1--------------------------------------------------------->



              </tr>
              <!--***** /TR *****-->
            @endforeach

        </tbody>
<!-------------***********************----------------------->


      </table>
      <!---------------------Table------------------->
    </div>
  </div>
  <!-------------------------------------->
  <!-------------BODY--------------------->
</div>
 <!-- ----------------CARD--------------------- -->
@stop