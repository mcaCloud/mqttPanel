@extends('dashboard.layout')
@section('title','Areas de trabajo')

@section('content')
    
<!-- Esto me verifica si tiene cualquiera de los dos roles-->
@hasanyrole('super-administrador|administrador')
<!-- Como la ruta esta en DASHBOARD no debemos olvidar ponerlo porque sino no encuentra la ruta-->
<a href="{{ route('dashboard::categorias.create') }}" class="btn btn-success">Crear Área de trabajo</a>
<!------------------------------>
<!----------OPTIONs------------->
<!------------------------------>
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

            <a href="#" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Recuperar archivos
            </a> 
        </li>  

    </ul>
</p>
<!------------------------------>
<!----------OPTIONs------------->
<!------------------------------>
@endhasrole

<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-6">
  <!-------------------------------------->
  <!--------- Header---------------------->
  <div class="card-header py-3">
    <button class="btn-info btn-lg"><strong>Áreas de trabajo</strong></button>
  </div>

  <!-------------------------------------->
  <!--------- BODY---------------------->
  <div class="card-body table-responsive">
    <!---------------------Table------------------->
    <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
    <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
    <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">
      <!----------------->
      <thead>
        <tr>
          <th>Lista de áreas de trabajo</th>
          <th>Servicios Activos</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <!--Aqui tomo la variable ('folders') que cree en el metodo Index del controloador de User-->

        <tbody>
            @foreach ($items as $index => $item)

            <!------------------------------------------->
            <!-------------------ROW--------------------->
            <!-- Es row es super importante para que funcione la Datatable con el search
              Al final lo que hago para agregar el search es añadir la opcion en el template de layout donde tengo el JS. -->
            <tr>
                <!--Me recorre cada uno de los resultados-->

                <!-------------------------------------->
                <td>
                    <div class="col-md-12">
                        {{$item->name}} 
                    </div>  
                </td>

                <!-------------------------------------->
                <td>                    
                <!-- Inicializamos un contador para saber cuatos archivos tengo en cada folder-->
                    <?php $contador=0 ?>

                    <!--Recorro cada archivo en el folder-->
                    @foreach ($folders as $folder)
                        <!-- Busco los archivos cuyo 'folder_id' sea igual al 'id' del folder en que estamos-->
                        @if($folder->cathegory_id == $item->id)
                            <!--Simplemente me esta contando cada vuelta que coincida el ID con el folder_id-->
                            @if(!isset($folder->deleted_at))
                                <?php $contador=$contador+1 ?>
                            @else
                                <?php  $contador=$contador ?>
                            @endif
                        @else
                        @endif                               
                    @endforeach

                    <!-- Ahora si el contador en mayor a cero que me imprima cuantos archivos hay-->
                    @if($contador >0)
                        <p class="card-text"><small class="text-muted"> Servicios activos: {{ $contador}}</small>
                        </p>
                        <!--Si el folder no tiene archivos que lo imprima-->
                    @else
                        <p class="card-text"><small class="text-muted">No hay ningún servicio activo</small>
                        </p>                            
                    @endif
                </td>
                <!--------------------------------------->
                <!------------ BOTONES ------------------>
                <td class="d-flex justify-content-center">
                    @include('dashboard.cathegory.partials.buttonsCathegory')    
                </td>
            </tr>
            @endforeach
        </tbody>         
    </table>
  </div>
</div>

@stop

                                                                      