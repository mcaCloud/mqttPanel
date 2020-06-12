@extends('dashboard.layout')

@section('content')


<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row col-12">
      <div class="col-6">
        <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">Lista de Permisos</h6>
      </div>
      <div class="col-6">
        <a href="{{ route('dashboard::permissions.create') }}" class="btn btn-success btn-icon-split float-right">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text">Nuevo Permiso</span>
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div>
      <table id="datatable-responsive" class="table table-striped  dt-responsive">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
              <tr>
                <td>{{$index + 1}}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->display_name }}</td>
                <td>{{ $item->description }}</td>
                <td class="d-flex justify-content-center">


                  <a href="{{ route('dashboard::permissions.edit', ['permission' => $item->id, 'page' => $page]) }}" class="btn btn-info btn-circle btn-sm" title="Editar" style="margin:1px">
                    <span class="icon">
                      <i class="fas fa-pen-alt"></i>
                    </span>
                  </a>


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
                                <p>¿Seguro que quieres eliminar el role de
                                  <strong>{{$item->name}}</strong>?
                                </p>

                                <p class="text-danger"style="text-align: justify">
                                  <small >Este permiso será eliminado directamente de la base de datos.</small>
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
   
                                <!-- Para crear la parte de Delete necesito un form que envie un POST al browser. Actualmente los browsers no soportan DELETE method, este es un work arround -->
                                <form action="{{ route('dashboard::permissions.destroy', ['permission' => $item->id])}}" title="Eliminar" style="margin:1px" method="post">
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
              </tr>
            @endforeach
        </tbody>
      </table>
      @if($items->total() > 0)
          <div class="row">
              <div class="col-sm-4 text-muted font-13">Mostrando registros del {{$items->firstItem()}} al {{$items->lastItem()}} de {{$items->total()}}.</div>
              <div class="col-sm-8 text-right">{{$items->appends(['search' => request('search')])->links()}}</div>
          </div>
      @endif
    </div>
  </div>
</div>

@stop
