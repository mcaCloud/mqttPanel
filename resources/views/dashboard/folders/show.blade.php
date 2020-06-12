@extends('dashboard.layout')
@section('title','Folders')

@section('content')

    <!-- Esto me verifica si tiene cualquiera de los dos roles-->
    @hasanyrole('super-administrador|administrador')
      <p>
        <!-- Como la ruta esta en DASHBOARD no debemos olvidar ponerlo porque sino no encuentra la ruta-->

        
        <a href="{{ route('dashboard::archivos.create',['id' =>$folder->id])}}" class="btn btn-success">Crear documento</a>

        <p>
        <!-- Esto es para que no nos pongo bullt points-->
        <ul style="list-style: none;">

            <li>
                <a href="{{route('dashboard::folders.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
                </a>

                <span class="separador">| </span>

                <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
                </a> 

                <span class="separador">| </span>

                <a href="#" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Borrados
                </a> 
            </li>  

        </ul>
        </p>
    @endhasrole

    <div class="card shadow mb-6">
<!-- ----------------CARD--------------------- -->
          <!-------------------------------------->
          <!--------- Header---------------------->
          <div class="card-header py-3">
            <h3><strong>{{$folder->name}}</strong></h3>
          </div>


        <div class="card-body table-responsive">

            <!---------------------Table------------------->
          <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
          <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
          <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">
            <!----------------->
            <thead>
              <tr>

                <th>Nombre del archivo</th>
                <th>Acciones</th>
              </tr>
            </thead>
           <!--Aqui tomo la variable ('files') que cree en el metodo Index
                del controloador de User-->
            @foreach ($files as $index => $file)
            <tbody>
                <!--Me recorre cada uno de los resultados-->
                <td>

                  <div class="row">
                      <div class="col-md-4">
                        {{$file->filename}} 
                      </div>

                      <div class="col-md-8">
                        <a  href="{{ route('dashboard::users.toggleAccess', ['user' => $file->id, 'type' => 'access_app']) }}"

                        data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Acceder a la aplicación">

                        <i class="fa @if( $file->access_app ) fa-toggle-on @else fa-toggle-off @endif fa-2x"></i>

                        </a>
                      </div>

                  </div>
  
                </td>
                <!--------------------------------------->
                <!------------ BOTONES ------------------>
                <td class="d-flex justify-content-center">

                <!------------ Ver ------------------>
                  <a href="{{ url('/download', $file->id) }}" class="btn btn-success btn-circle btn-sm" title="download" style="margin:1px">
                    <span class="icon">
                      <i class="fas fa-eye"></i>
                    </span>
                  </a>
                <!------------ /ver ------------------>

                <!------------ Descargar ------------------>
                  <a href="{{ url('/download', $file->id) }}" class="btn btn-info btn-circle btn-sm" title="download" style="margin:1px">
                    <span class="icon">
                      <i class="fas fa-download"></i>
                    </span>
                  </a>
                <!------------ /Descargar ------------------>

<!----------------------------DELETE-------------------------------------->
                <!------------------------------------------------------------->
                <!---------------------------OVERLAY--------------------------->
                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                <!-- Lo primero que tengo es un boton que nos hace ancla al DIV de abajo con id="vidtorModal"
                Hay que indicarle el ID del usuario para que cada ventanita y cada boton sea del usuario correspondiente. IMPORTANRE
                En este caso es el FILE-ID de la linea que estoy-->
                <a href="#victorModal{{$file->id}}" role="button" class="btn btn-danger btn-circle" data-toggle="modal" style="width: 30px;height: 30px;">
                    <span class="icon">
                      <i class="fas fa-trash"></i>
                    </span>
                </a>
      
                <!-- Modal / Ventana / Overlay en HTML -->
                <div id="victorModal{{$file->id}}" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                <h4 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Estás seguro?</h4>
                            </div>

                            <div class="modal-body">
                                <p>¿Seguro que quieres eliminar a 
                                  <strong>{{$file->name}}</strong>?
                                </p>

                                <p class="text-danger"style="text-align: justify">
                                  <small >Este usuario será eliminado directamente de la base de datos junto con toda su información. La información del usuario no podrá ser recuperada.</small>
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
   
                                <!-- Para crear la parte de Delete necesito un form que envie un POST al browser. Actualmente los browsers no soportan DELETE method, este es un work arround -->
                                <form action="{{ route('dashboard::archivos.destroy', [$file->id])}}" title="Eliminar" style="margin:1px" method="post">
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
              </td>
            

            </tbody>
            @endforeach
        </div>

    </div>
   

@stop