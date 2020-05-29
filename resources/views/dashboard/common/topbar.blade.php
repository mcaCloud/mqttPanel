<!------------------------------------------------------->
<!----------------------- Topbar ------------------------>
<!------------------------------------------------------->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <!-------------------------------------->
  <!---------- Sidebar Toggle ------------>
  <!--Esta es el boton para dispositivos moviles
      Este boton colapsa la menu lateral
      Ojo con los estilos que estan muy bien-->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <!--Icono de barras-->
    <i class="fa fa-bars"></i>
  </button>
  <!---------- /Sidebar Toggle------------->
  <!-------------------------------------->


  <!------------------------------------->
  <!----------- Topbar Navbar ----------->
  <ul class="navbar-nav ml-auto">

    <!--////////////////////////////////////////////////////////-->
    <!-------------------------->
    <!-------- ALERTS ---------->
        @include('dashboard.common.topBarNotifications')
    <!-------- Alerts ---------->
    <!-------------------------->
    <!--////////////////////////////////////////////////////////-->


    <!--Esto solo es una linea para dividir partes-->
    <div class="topbar-divider d-none d-sm-block"></div>


    <!--------User Information ------------->
    <li class="nav-item dropdown no-arrow">

      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

        <div style="">        
            <!--------MINIATURA----------------->
              <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
              <!-- Debode utilizar el AUTHUSER para que la miniatura me funcione en todas la paginas-->
              @if(Storage::disk('avatars')->has(Auth::user()->image))
                <!-- Le concateno a la ruta minitura la imagen que quiero ver-->
                <!-- Aqui estoy utilizando el metodo del UserProfile ('getImage')-->
                <!-- Como segundo parametro la ruta necesita el 'filename', entonces le paso el path de la image que guardé en el metodo update-->
                <!--La quiero centrar entonces utilizo una posicion relativa y 25% hacia la izquierda-->
                <img src="{{url('/miniatura/'.Auth::user()->image)}}" class="img-fluid" style="vertical-align: middle;width:50px;height:50px;border-radius: 50%;box-shadow: 0 0 8px rgba(0,0,0,0.8);" />   
              @else
                  <img src="{{ URL::to('/') }}/img/avatar.png" class="img-fluid" style="vertical-align: middle;width: 50%;height: 50%;border-radius: 50%;box-shadow: 0 0 8px rgba(0,0,0,0.8);"/>
              @endif
                         
                    
            <!----------------------/IMAGE-FORM----------------------------->
        </div>

      </a>

      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        
        <!-- Para que el titulo me lleve al perfil tenemos que pasarle el nombre de la ruta y el parametro del [id] que estamos recorriendo en este preciso instante-->
        <!-- Como estamos en la plantilla principal el llamado a las propiedades del ojeto user se hacen diferente. So se puede utilizar el objeto userProfile que creamos en el controlador porque no funciona.Tenemos que cojer las propiedades del Auth::user -->
        <a class="dropdown-item" href="{{route('perfil',['id' =>Auth::user()->id]) }}">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Perfil
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Configuración
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Cerrar Sesión
        </a>
      </div>
    </li>
    <!--------User Information ------------->
    <!--////////////////////////////////////////////////////////-->


  </ul>   
  <!----------- Topbar Navbar ----------->
  <!------------------------------------->
<!--///////////////////////////////////////////////////////-->

</nav>
<!------------------------------------------------------->
<!----------------------- /Topbar ------------------------>
<!------------------------------------------------------->