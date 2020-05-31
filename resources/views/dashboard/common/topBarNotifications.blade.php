    <!-------------------------->
    <!-------- ALERTS ---------->
    <li class="nav-item dropdown no-arrow mx-1">

      <!--------ICONO-BUTTON-------->
       <!-- El hrefe es para hacer la campanita clickable-->
       
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <!-- Le doy el estilo de la campana con el fa fa- -->
          <i class="fas fa-bell fa-fw"></i>

          <!-- Counter - Alerts -->

          <!--Aqui es necesario hacer una comprobacion para que el numerito de unread notifications no aparezca a menos que haya alguna.
            Si no hay niguna no esta en el IF-->
          @if(Auth::user()->unreadNotifications->count())
            <!-- Trabajar la connectividad a los mensajes
                 Ahora esta de manera estatica-->
                <span class="badge badge-danger badge-counter">{{Auth::user()->unreadNotifications->count()}}</span>

          @endif
      </a>
      <!--------ICONO-BUTTON-------->

      <!--------Alerts-menu -------------->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <a href="{{route('notifications')}}">

          <!--Aqui es necesario hacer una comprobacion para que el numerito de unread notifications no aparezca a menos que haya alguna.
          Si no hay niguna no esta en el IF-->
          @if(Auth::user()->unreadNotifications->count())
            <!-- Trabajar la connectividad a los mensajes
                 Ahora esta de manera estatica-->
                <h6 class="dropdown-header"> Mensajes<span class="badge badge-danger badge-counter">{{Auth::user()->unreadNotifications->count()}}</span></h6>
          @else
                <h6 class="dropdown-header"> Mensajes</h6>
          @endif
        
        </a>

        <!-- Por cada notificacion sin leer que tenga el authorized user que me la pase hacia la variable notification-->
        @foreach(Auth::user()->unreadNotifications as $notification) 
          <!-- En caso de que salga el error de Undefined index verificamos 
          que en las notificaciones los indices solicitados existen
          Me paso que sabia que todo estaba bien pero seguia fallando
           Era que algunas notificaciones en la base de datos que habia enviado antes no tenia los campos de indice. Por eso no lo encontraba . Para ello comence a probar si llegaban y descubri que algunos indices no llegaban en algunas notiicaciones.
           Por eso el programa decia que no encontraba esos indices pero era solo en algunas notificaciones, por eso la pagina no podia cargar.
           Para probar utilizo el ISSET y verifico-->
        <!--{{isset($notification->data['email'])}}-->
          <!-- Aqui trabajamos el icono de cada alerta-->
          <!-- Le metemos un background para diferenciar las no leidas de las leidas-->
          <a class="dropdown-item d-flex align-items-center" href="{{route('notificationDetail',[$notification->id])}}" style="background-color: lightgray ">
          <!----------------------------------------------->
          
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
              <div class="small text-white"> 
                <strong style="text-shadow: 2px 2px 8px #323231">
                  Enviada {{$notification->created_at->diffForHumans()}}
                </strong>                
              </div>

              {{$notification->data['name']}} ha sido {{$notification->data['action']}} 

            </div>
          </a>

        @endforeach

        <!-- Este link me  lleva a una pagina con todas las alertas-->
        <a class="dropdown-item text-center small text-gray-500" href="{{route('markAllAsRead')}}">Marcar todo como leido
        </a>
        <!----------/MSJ-4----------------->

      </div>
      <!--------Alerts-menu -------------->
    </li>
    <!-------- Alerts ---------->
    <!-------------------------->