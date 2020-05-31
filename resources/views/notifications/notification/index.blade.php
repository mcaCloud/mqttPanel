
<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-5">
  <!-------------------------------------->
  <!--------- Header---------------------->
  <div class="card-header py-3">

    <!------12COL------------->
    <div class="row col-12">

      <div class="col-6">
        <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">Lista de Notificaciones</h6>
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

  @foreach(Auth::user()->notifications as $notification)
  
  <h3>{{$notification->data['body']}}</h3>

  @endforeach

  </div>
  
</div>

