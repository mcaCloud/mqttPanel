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

      <div class="col-6">
        <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">Lista de colaboradores</h6>
      </div>


      <div class="col-6">
        <!-- Utilizo el metodo CREATE del controlador de User-->
        <a href="#" class="btn btn-success btn-icon-split float-right">
          <!-- Le meto un simbolo de +, con una luminosidad del 50%-->
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>

          <span class="text">Nueva notificación</span>
        </a>
      </div>

    </div>
    <!------12COL------------->

  </div>
  <!--------- Header---------------------->
  <!-------------------------------------->

  <!-------------------------------------->
  <!-------------BODY--------------------->
  <div class="card-body">
   
      
      <!---------------------Table------------------->
      <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
      <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
      <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">
        <!----------------->
        <thead>
          <tr>

          </tr>
        </thead>
        <!----------------->
        @foreach ($notification as $index => $item)


                  <div class="row alert alert-success">
                    <div class="media col-md-2">

                      <!--------------------------------->
                      <div class="media-left">
                          <div class="media-object">
                            <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                          </div>
                        </div>
                      </div>
                      <!--------------------------------->
                      <div class="col-md-2"><h6>{{'$item'}} </h6></div>
                      
                      <!--------------------------------->
                      <div class="col-md-4">
                        <h6>{{$item->notifiable_id}}{{$item->created_at->diffForHumans()}}</h6>
                      </div>
                      <!--------------------------------->
                      <div class="col-md-1">                                
                        <a href="{{ route('notificationDetail', ['notification' => $item->id, 'page' => $page]) }}" class="btn btn-info btn-circle btn-sm" title="Editar" style="margin:1px">
                           <span class="icon">
                               <i class="fas fa-eye"></i>
                            </span>
                        </a>
                      </div>
                      <!--------------------------------->
                      <div class="col-md-1">                          
                       <!--La URL lo que me dice es que en el nacespace definido en la rutas 'dashboard', existe una ruta cuyo nombre es 'users.toggleAccess'
                        Esta ruta me abre el controlador de 'UserController@toggleAccess'-->
                        <!-- En donde 'user' es igual al ID de 'item' o usuario que estoy recorriendo-->
                        <!-- 'type' contiene el permiso de 'access_web'-->
                      <!-- 'page' contiene a la variable 'page'-->
                        @if($item->read_at)

                          <a  href="{{ route('oneRead', ['notification' => $item->id]) }}" 

                            data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Marcar como leida">

                            <!--Le meto un Fa Icon con un IF para cambiarlo ON/OFF--> 
                            <i class="fa @if(!is_null($item->read_at) ) fa-toggle-off @else fa-toggle-on @endif fa-2x"></i>
                          </a>

                        @else

                          <a  href="{{ route('oneUnRead', ['notification' => $item->id]) }}" 

                            data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Marcar como leida">

                            <!--Le meto un Fa Icon con un IF para cambiarlo ON/OFF--> 
                            <i class="fa  @if(!is_null($item->read_at) ) fa-toggle-off @else fa-toggle-on @endif fa-2x"></i>
                          </a>
                        @endif
                      </div>

                  </div>
                </td>

            </tr>
            
        </tbody>
        @endforeach
      </table>
      <!---------------------Table------------------->

 
  <!-------------------------------------->
  <!-------------BODY--------------------->

</div>

<!-- ----------------CARD--------------------- -->
@stop
