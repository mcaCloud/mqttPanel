@extends('dashboard.layout')

@section('content')


<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-6">
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
        <a href="{{ route('dashboard::users.create') }}" class="btn btn-success btn-icon-split float-right">
          <!-- Le meto un simbolo de +, con una luminosidad del 50%-->
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>

          <span class="text">Nuevo usuario</span>
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
    <div>

      <!---------------------Table------------------->
      <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
      <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
      <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">
        <!----------------->
        <thead>
          <tr>
            <!-- Extra TD para el child row-->
            <th></th>
            <th>Identificación</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acceso a la web</th>
            <th>Acceso a la app</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <!----------------->
        <tbody>
            <!--Aqui tomo la variable ('items') que cree en el metodo Index
                del controloador de User-->
            @foreach ($items as $index => $item)
              <tr>
                <!-- Extra TD para el child row-->
                <th></th>
                <!--Me recorre cada uno de los resultados-->
                <td>{{$item->rut}}</td>

                <td>{{$item->completeName()}}</td>

                <td>{{$item->email}}</td>

                <!----------Esto es para el acceso a la WEB--------->
                <td>

                  <!--La URL lo que me dice es que en el nacespace definido en la rutas 'dashboard', existe una ruta cuyo nombre es 'users.toggleAccess'
                  Esta ruta me abre el controlador de 'UserController@toggleAccess'-->
                  <!-- En donde 'user' es igual al ID de 'item' o usuario que estoy recorriendo-->
                  <!-- 'type' contiene el permiso de 'access_web'-->
                  <!-- 'page' contiene a la variable 'page'-->
                  <a  href="{{ route('dashboard::users.toggleAccess', ['user' => $item->id, 'type' => 'access_web', 'page' => $page]) }}" 

                    data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Acceder a la web">

                    <!--Le meto un Fa Icon con un IF para cambiarlo ON/OFF--> 
                    <i class="fa @if( $item->access_web ) fa-toggle-on @else fa-toggle-off @endif fa-2x"></i>
                  </a>
                </td>

                <!----------Esto es para el acceso a la APP--------->
                <td>
                  <a  href="{{ route('dashboard::users.toggleAccess', ['user' => $item->id, 'type' => 'access_app', 'page' => $page]) }}"

                   data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Acceder a la aplicación">

                    <i class="fa @if( $item->access_app ) fa-toggle-on @else fa-toggle-off @endif fa-2x"></i>
                  </a>
                </td>
                <!--------------------------------------->
                <!------------ BOTONES ------------------>
                <td class="d-flex justify-content-center">

                  <!------------ EDIT ------------------>
                  <a href="{{ route('dashboard::users.edit', ['user' => $item->id, 'page' => $page]) }}" class="btn btn-info btn-circle btn-sm" title="Editar" style="margin:1px">
                    <span class="icon">
                      <i class="fas fa-pen"></i>
                    </span>
                  </a>
                <!------------ /EDIT ------------------>

<!----------------------------DELETE-------------------------------------->
                <!------------------------------------------------------------->
                <!---------------------------OVERLAY--------------------------->
                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                <!-- Lo primero que tengo es un boton que nos hace ancla al DIV de abajo con id="vidtorModal"
                Hay que indicarle el ID del usuario para que cada ventanita y cada boton sea del usuario correspondiente. IMPORTANRE
                En este caso es el ITEM-ID de la linea que estoy-->
                <a href="#victorModal{{$item->id}}" role="button" class="btn btn-danger btn-circle" data-toggle="modal" style="width: 30px;height: 30px;">
                    <span class="icon">
                      <i class="fas fa-trash"></i>
                    </span>
                </a>
      
                <!-- Modal / Ventana / Overlay en HTML -->
                <div id="victorModal{{$item->id}}" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                <h4 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Estás seguro?</h4>
                            </div>

                            <div class="modal-body">
                                <p>¿Seguro que quieres eliminar a 
                                  <strong>{{$item->completeName()}}</strong>?
                                </p>

                                <p class="text-danger"style="text-align: justify">
                                  <small >Este usuario será eliminado directamente de la base de datos junto con toda su información. La información del usuario no podrá ser recuperada.</small>
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
   
                                <!-- Para crear la parte de Delete necesito un form que envie un POST al browser. Actualmente los browsers no soportan DELETE method, este es un work arround -->
                                <form action="{{ route('dashboard::users.destroy', ['user' => $item->id])}}" title="Eliminar" style="margin:1px" method="post">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-success"><i class="far fa-thumbs-up"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                  </div>
              </div>
              <!--------------------/OVERLAY--------------------->
<!----------------------------DELETE-------------------------------------->                  
                </td>
                <!------------ /BOTONES ------------------>
                <!--------------------------------------->
              </tr>
            @endforeach
        </tbody>
      </table>
      <!---------------------Table------------------->

      @if($items->total() > 0)
          <div class="row">
              <div class="col-sm-4 text-muted font-13">Mostrando registros del {{$items->firstItem()}} al {{$items->lastItem()}} de {{$items->total()}}.</div>
              <div class="col-sm-8 text-right">{{$items->appends(['search' => request('search')])->links()}}</div>
          </div>
      @endif
    </div>
  </div>
  <!-------------------------------------->
  <!-------------BODY--------------------->

  <div class="card-header py-3">
    <div class="row col-12">
      <div class="col-6">
        <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">Exportaciones en excel</h6>
      </div>
    </div>
    <div class="row col-12">
        <div class="col-4"></div>
        <div class="col-2">
          <a href="{{ route('dashboard::users.export', [ 'type' => 'mapping' ]) }}" target="_blank" class="btn btn-success btn-icon-split float-right">
            <span class="icon text-white-50">
              <i class="fas fa-download"></i>
            </span>
            <span class="text">Mapping <i class="fas fa-file-excel"></i></span>
          </a>
        </div>
        <div class="col-2">
          <a href="{{ route('dashboard::users.export', [ 'type' => 'query' ]) }}" target="_blank" class="btn btn-success btn-icon-split float-right">
            <span class="icon text-white-50">
              <i class="fas fa-download"></i>
            </span>
            <span class="text">Query <i class="fas fa-file-excel"></i></span>
          </a>
        </div>
        <div class="col-2">
          <a href="{{ route('dashboard::users.export', [ 'type' => 'view' ]) }}" target="_blank" class="btn btn-success btn-icon-split float-right">
            <span class="icon text-white-50">
              <i class="fas fa-download"></i>
            </span>
            <span class="text">View <i class="fas fa-file-excel"></i></span>
          </a>
        </div>
        <div class="col-2">
          <a href="{{ route('dashboard::users.export', [ 'type' => 'collection' ]) }}" target="_blank" class="btn btn-success btn-icon-split float-right">
            <span class="icon text-white-50">
              <i class="fas fa-download"></i>
            </span>
            <span class="text">Collection <i class="fas fa-file-excel"></i></span>
          </a>
        </div>
    </div>
  </div>
</div>
<!-- ----------------CARD--------------------- -->
@stop