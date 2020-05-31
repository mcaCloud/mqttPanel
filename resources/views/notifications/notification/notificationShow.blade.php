@extends('dashboard.layout')
@section('title','Notificacion')

@section('content')

<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-5">

  <!-------------------------------------->
  <!--------- Header---------------------->
  @foreach ($detail as $index => $item)
  <div class="card-header py-3">

    <!------12COL------------->
    <div class="row col-12">
     
      <!---------- BOTONES --------------->


      <div class="span">
        <!-- Utilizo el metodo CREATE del controlador de User-->
        <a href="{{route('notifications')}}" class="btn btn-success btn-icon-split float-left">
          <!-- Le meto un simbolo de +, con una luminosidad del 50%-->
          <span class="icon text-white-50">
            <i class="fas fa-arrow-circle-left"></i>
          </span>

          <span class="text">Atrás</span>
        </a>
      </div>



          <!----------------------DELETE--------------------->
          <!------------------------------------------------------------->
          <!---------------------------OVERLAY--------------------------->
          <!-- Botón en HTML (lanza el modal en Bootstrap) -->
          <!-- Lo primero que tengo es un boton que nos hace ancla al DIV de abajo con id="vidtorModal"
          Hay que indicarle el ID de la notificaion para que cada ventanita y cada boton sea de la notificacion correspondiente. IMPORTANRE
          En este caso es el ITEM-ID de la linea que estoy-->

          <div class="span">
              <a href="#victorModal{{$item->id}}" role="button" class="btn btn-danger btn-icon-split float-left" data-toggle="modal">
                  <span class="icon text-white">
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
                          <p>¿Seguro que quieres eliminar esta notificación?</p>

                          <p class="text-danger"style="text-align: justify">
                            <small >Este notificación será eliminada directamente de la base de datos.</small>
                          </p>
                      </div>

                      <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
       
                            <!-- Para crear la parte de Delete necesito un form que envie un POST al browser. Actualmente los browsers no soportan DELETE method, este es un work arround -->
                           <form action="{{route('notificationDelete',[$item->id])}}" title="Eliminar" style="margin:1px" method="post">
                              @csrf
                              {{method_field('DELETE')}}
                              <button type="submit" class="btn btn-success"><i class="far fa-thumbs-up"></i> Eliminar
                              </button>
                            </form>
                        </div>

                    </div>
                </div>
              </div>
          </div>
        
          <!--------------------/OVERLAY--------------------->
          <!---------------------DELETE----------------------->  
       
      <!---------- BOTONES --------------->
      
    </div>
    <!------12COL------------->

  </div>
  <!--------- Header---------------------->
  <!-------------------------------------->

<!--/////////////////////////////////////////////////////////-->

<!---------------------Table------------------->
      <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
      <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
      <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">

        <!--Aqui tomo la variable ('details') que cree en el metodo Index
                del controloador de User-->        

              <tbody>
              <!--***** TR *****-->
              <tr>
                <!--Me recorre cada uno de los resultados-->
<!-- TD 1--------------------------------------------------------->
                <td>

                  <h5>Asunto:</h5>
                  <p>Queremos informarte que {{$item->data['name']}} ha sido {{$item->data['action']}} en {{$item->data['place']}} {{$item->created_at->diffForHumans()}}.</p>
                  <p> El correo electrónico de {{$item->data['name']}} es {{$item->data['email']}}.</p>
                  <p></p>
                  <p>Si deseas tener el registro de esta notificación, guarda los siguientes datos:</p>
                  <ul>
                    <li> ID de la notificación: {{$item->id}}</li>
                    <li> ID de la notificación: {{$item->type}}</li>
                  </ul>
                  <p>Cualquier información que necesites no dudes en contactarme!</p>
                  <p>Saludos,</p>
                </td>
              </tr>
              @endforeach

        </tbody>
      </table>
</div>
@stop