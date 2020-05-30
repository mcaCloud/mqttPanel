    <!-------------------------->
    <!-------- ALERTS ---------->
    <li class="nav-item dropdown no-arrow mx-1">

      <!--------ICONO-BUTTON-------->
       <!-- El hrefe es para hacer la campanita clickable-->
       
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <!-- Le doy el estilo de la campana con el fa fa- -->
          <i class="fas fa-bell fa-fw"></i>

          <!-- Counter - Alerts -->
          <!-- Trabajar la connectividad a los mensajes
               Ahora esta de manera estatica-->
          <span class="badge badge-danger badge-counter">{{Auth::user()->notifications->count()}}</span>
      </a>
      <!--------ICONO-BUTTON-------->

      <!--------Alerts-menu -------------->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">

        <a href="#"><h6 class="dropdown-header">
          
          Centro de mensajes

        </h6></a>

        <!-- Por cada notificaion que tenga el authorized user que me la pase hacia la variable notification-->
        @foreach(Auth::user()->notifications as $notification)

          <!----------MSJ-2----------------->

          <!-- Aqui trabajamos el icono de cada alerta-->
          <a class="dropdown-item d-flex align-items-center" href="#">

            <!-- Comparamos el tipo de notificacion que me ingresa
                Y todas las de userDeleted me vendran con el siguinte icono-->
            @if ($notification->type == 'App\Notifications\userDeleted')
              <div class="mr-3">
                <div class="icon-circle bg-danger">
                  <i class="fas fa-exclamation-triangle text-white"></i>
                  
                </div>
              </div>
            @elseif ($notification->type == 'App\Notifications\userCreated')
              <div class="mr-3">
                <div class="icon-circle bg-success">
                  <i class="fas fa-check-circle text-white"></i>
                  
                </div>
              </div>
            @elseif ($notification->type == 'App\Notifications\userUpdated')
             <div class="mr-3">
                <div class="icon-circle bg-primary">
                  <i class="fas fa-user-edit text-white"></i>
                  
                </div>
              </div>
            @else
            @endif

            <div>
              <div class="small text-gray-500"> Enviada {{$notification->created_at->diffForHumans()}}
              </div>

              {{$notification->data['name']}} ha sido {{$notification->data['action']}} 

            </div>
          </a>
          <!----------/MSJ-2----------------->

        @endforeach

        <!----------MSJ-4----------------->
        <!-- Este link me  lleva a una pagina con todas las alertas-->
        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        <!----------/MSJ-4----------------->

      </div>
      <!--------Alerts-menu -------------->
    </li>
    <!-------- Alerts ---------->
    <!-------------------------->