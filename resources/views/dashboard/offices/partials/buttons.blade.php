
<!------------ VER ------------------>
<a href="{{route('dashboard::offices.show',['id' => $item->id, 'page' => $page])}}" class="btn btn-success  btn-lg" title="Ver" style="margin:1px">
    <span class="icon">
        <i class="fas fa-play"></i>
    </span>
</a>
 <!------------ /VER ------------------>

<!---------- EDIT ------------------>
<a href="{{route('dashboard::offices.edit',['id' => $item->id, 'page' => $page])}}" class="btn btn-warning  btn-lg" title="Ver" style="margin:1px">
    <span class="icon">
        <i class="fas fa-edit"></i>
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
                <p>¿Seguro que quieres eliminar a <strong>{{$item->name}}</strong>?
                </p>

                <p class="text-danger"style="text-align: justify">
                    <small >Este usuario será eliminado directamente de la base de datos junto con toda su información. La información del usuario no podrá ser recuperada.</small>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>              
                <!-- Para crear la parte de Delete necesito un form que envie un POST al browser. Actualmente los browsers no soportan DELETE method, este es un work arround -->
                <form action="{{ route('dashboard::offices.destroy', ['user' => $item->id])}}" title="Eliminar" style="margin:1px" method="post">
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
