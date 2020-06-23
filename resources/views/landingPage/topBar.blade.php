
<!--///////////////////////////////////////////////////////////////////////-->
<!--------------------------TOP-NAVIGATION-BAR-------------------------------->
<!--///////////////////////////////////////////////////////////////////////-->
<nav class="navbar navbar-default navbar-static-top" style="box-shadow: 0 0 10px 0 black;" >


    <!--///////////////////////////////////////////////////////////////////////-->
    <!--------------------------TOP-BAR---------------------------------------- -->
    <div class="container col-md-12 col-md-offset-1">

        <!------------------------------------------------------------------------ -->   
        <!--------------------------HEADER------------------------------------ -->
        <div class="navbar-header col-md-2">
            <!-- --------------Collapsed Hamburger ---------------->
            <!-- Esto es el menu responsive -->
             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- --------------/Collapsed Hamburger --------------->
         
        </div>
        <!--------------------------/HEADER---------------------------------------- -->   
        <!------------------------------------------------------------------------ --> 


        <!-------------------------COL-8----------------------------------------- -->
        <!------------------------------------------------------------------------ -->
        <div class="navbar-header col-md-8"> 
        </div>         
        <!-------------------------COL-8----------------------------------------- -->
        <!------------------------------------------------------------------------ -->


        <!------------------------------------------------------------------------ -->
        <!--------------------------LEFT-HEADER---------------------------------------- -->
        <div class=" col-md-2 collapse navbar-collapse" id="app-navbar-collapse">

            <!------------------                            ------------------- -->
            <!-- --------------------- Right Side Of Navbar-------------------- -->
            <ul class="nav navbar-nav navbar-right">

                <!-- Authentication Links -->
                <!-- SI no estamos identificados nos muestra el login y registro -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}"><span class=" glyphicon glyphicon-user"> Login</a></li>
                    

                <!-- SI  estamos identificados nos muestra la pagina de USUARIO -->
                @else
     
                <!-- Agregamos para que se vea el Alias registrado-->
                <!-- Tendre un dropdown con el nombre del USUARIO identificado -->
                <li class="dropdown">

                    <!--Aqui lo que hago es agragar la imagen dentro del ahref para que la imgen ser el inicio del dropdown menu-->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      
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
                              <img src="{{ URL::to('/') }}/img/avatar.png" class="img-fluid" style="vertical-align: middle;width: 50px;height: 50px;border-radius: 50%;box-shadow: 0 0 8px rgba(0,0,0,0.8);"/>
                          @endif
                    </a>  

                    <!-- ---------/OPCIONES-MENU --------------->
                    <ul class="dropdown-menu" role="menu">

                        <li>        
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="glyphicon glyphicon-off mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                            </a>

                            <a class="dropdown-item" href="{{ route('dashboard::index') }}">
                                <i class="glyphicon glyphicon-wrench mr-2 text-gray-400"></i>
                                    Panel de control
                            </a>

                            <a class="dropdown-item" href="{{route('perfil',['id' =>Auth::user()->id]) }}">
                              <i class="glyphicon glyphicon-user mr-2 text-gray-400"></i>
                              Perfil
                            </a>

                            <a class="dropdown-item" href="#">
                                <i class="glyphicon glyphicon-bell mr-2 text-gray-400"></i>
                                    Notificaciones
                            </a>

                        </li>
 
                    </ul>
                    <!-- ---------/OPCIONES-MENU --------------->
                </li>

                @endif
            </ul>
            <!-- -------------------- /Right Side Of Navbar------------------- -->
            <!------------------                            ------------------- -->

        </div>
        <!--------------------------/LEFT-HEADER---------------------------------------- -->
        <!------------------------------------------------------------------------ -->

    </div>
    <!--------------------------TOP-BAR---------------------------------------- -->
    <!--///////////////////////////////////////////////////////////////////////-->

</nav>
<!--///////////////////////////////////////////////////////////////////////-->
<!--///////////////////////////////////////////////////////////////////////-->
