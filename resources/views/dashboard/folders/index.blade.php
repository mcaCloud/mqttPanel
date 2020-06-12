@extends('dashboard.layout')
@section('title','Folders')

@section('content')
    
    <!-- Esto me verifica si tiene cualquiera de los dos roles-->
    @hasanyrole('super-administrador|administrador')
      <p>
        <!-- Como la ruta esta en DASHBOARD no debemos olvidar ponerlo porque sino no encuentra la ruta-->
        <a href="{{ route('dashboard::folders.create') }}" class="btn btn-success">Crear</a>

    @endhasrole

     @hasanyrole('super-administrador|administrador')
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
        <div class="card-header py-3">
            
            <div class="card-deck">
                
                <!--Aqui tomo la variable ('items') que cree en el metodo Index
                        del controloador de FOLDERS-->
                @foreach ($items as $index => $item)
                    <div class="card mb-4 shadow mb-6">

                        <img class="card-img-top img-fluid "src="/img/folderIcon.png" style="width: 200px; height: 200px; display: block; margin: auto">

                        <div class="card-body">
                            <h4 class="card-title">{{$item->name}}</h4>

                            <!-- Inicializamos un contador para saber cuatos archivos tengo en cada folder-->
                            <?php $contador=0 ?>

                            <!--Recorro cada archivo en el folder-->
                            @foreach ($files as $file)

                                <!-- Busco los archivos cuyo 'folder_id' sea igual al 'id' del folder en que estamos-->
                                @if($file->folder_id == $item->id)
                                    <!-- Ahcemos un alista con los nombres de los folders-->
                                    <!--<li class="card-text"><small class="text-muted">{{ $file->filename}}</small>
                                    </li>-->
                                    <!--Simplemente me esta contando cada vuelta que coincida el ID con el folder_id-->
                                    <?php $contador=$contador+1 ?>
                                @else
                                @endif
                                
                            @endforeach

                            <!------------------------------------->
                            <!-- Ahora si el contador en mayor a cero que me imprima cuantos archivos hay-->
                            @if($contador >0)
                                <p class="card-text"><small class="text-muted">{{ $contador}} archivos</small>
                                </p>
                            <!--Si el folder no tiene archivos que lo imprima-->
                            @else
                                <p class="card-text"><small class="text-muted">No hay ningún archivo</small>
                                </p>                            
                            @endif
                                

                            <!--------------------------------------->
                            <!------------ BOTONES ------------------>
                            <div class="d-flex justify-content-center">

                              <!--------}}---- EDIT ------------------>
                              <a href="{{route('dashboard::folders.show',['id' => $item->id, 'page' => $page])}}" class="btn btn-success  btn-lg" title="Ver" style="margin:1px">
                                <span class="icon">
                                  <i class="fas fa-play"></i>
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
                            <a href="#victorModal{{$item->id}}" role="button" class="btn btn-danger btn-lg" data-toggle="modal" >
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
                                              <strong></strong>?
                                            </p>

                                            <p class="text-danger"style="text-align: justify">
                                              <small >Este usuario será eliminado directamente de la base de datos junto con toda su información. La información del usuario no podrá ser recuperada.</small>
                                            </p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
               
                                            <!-- Para crear la parte de Delete necesito un form que envie un POST al browser. Actualmente los browsers no soportan DELETE method, este es un work arround -->
                                            <form action="{{ route('dashboard::folders.destroy', ['user' => $item->id])}}" title="Eliminar" style="margin:1px" method="post">
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
                            </div>

                        </div>

                    </div> 
                    @endforeach
               
        </div>
    </div>
   </div>

@stop

                                                                      