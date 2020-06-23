@extends('dashboard.layout')
@section('title','Oficinas')

@section('content')

        <p>
        <!-- Esto es para que no nos pongo bullt points-->
        <ul style="list-style: none;">

            <li>
                <a href="{{route('dashboard::index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Página principal
                </a>

                <span class="separador">| </span>

                <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
                </a> 

                <span class="separador">| </span>

                <a href="#" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Recuperar datos
                </a> 
            </li>  

        </ul>
        </p>
<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-6">
  <!-------------------------------------->
  <!--------- Header---------------------->
  <div class="card-header py-3">

    <!------12COL------------->
    <div class="row col-12">

      <div class="col-6">
        <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">Lista de oficinas</h6>
      </div>


      <div class="col-6">
        <!-- Utilizo el metodo CREATE del controlador de User-->

         <a href="{{ route('dashboard::offices.create') }}" class="btn btn-success btn-icon-split float-right"">
          <!-- Le meto un simbolo de +, con una luminosidad del 50%-->
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>

          <span class="text">Nueva oficina</span>
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
            <th>Nombre de la oficina</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <!----------------->
        <tbody>
            <!--Aqui tomo la variable ('items') que cree en el metodo Index
                del controloador de User-->
                
            <!--Aqui tomo la variable ('items') que cree en el metodo Index
                        del controloador de FOLDERS-->
            @foreach ($items as $index => $item)
            <tr>

                <!--Me recorre cada uno de los resultados-->
                <td>{{$item->name}}</td>

                <!----------Esto es para el estado activo--------->
                <td>

                  <!--La URL lo que me dice es que en el nacespace definido en la rutas 'dashboard', existe una ruta cuyo nombre es 'users.toggleAccess'
                  Esta ruta me abre el controlador de 'UserController@toggleAccess'-->
                  <!-- En donde 'user' es igual al ID de 'item' o usuario que estoy recorriendo-->
                  <!-- 'type' contiene el permiso de 'access_web'-->
                  <!-- 'page' contiene a la variable 'page'-->
                  <a  href="{{ route('dashboard::offices.toggleAccess', ['office' => $item->id, 'type' => 'status', 'page' => $page]) }}" 

                    data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Acceder a la web">

                    <!--Le meto un Fa Icon con un IF para cambiarlo ON/OFF--> 
                    <i class="fa @if( $item->status ) fa-toggle-on @else fa-toggle-off @endif fa-2x"></i>
                  </a>
                </td>

                <!--------------------------------------->
                <!------------ BOTONES ------------------>
                <td class="d-flex justify-content-center">
                    @include('dashboard.offices.partials.buttons')
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
</div>

@stop

                                                                      