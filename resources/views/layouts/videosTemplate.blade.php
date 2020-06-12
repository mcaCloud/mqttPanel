<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Con esto puedo agregar un tiulo individual a los tabs--->
    <title>MCA- @yield('title','Página de videos')</title>
<!------------------------------------------- -->
    <!---------------- Styles ---------->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Este es importante para que funciones los Glyphicons.Por algun motivo solo asi me funciona -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    

    <!-- Cargamos el archivo de CSS particular que tenemos dentro del storage en la carpeta CSS que creamos. Utilizo un URL y la ruta ruta donde tengo el ASSET -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/style.css')}}"/>

  <!-- Con este link cargamos la configuracion del bootstrap.min.css, con todos los defaults-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <!--Esto lo coloco aqui para poder hacer PUSH de styles o scrips individuales en las vistas
        Es super poderoso para poder conbinar estilos en las vistas
        La vista que los ocupe solo tiene que hacer el PUSH y la RUTA-->
        @stack('styles')
        @stack('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--------------------------------------- -->
</head>

<!---------------------------------------------------------------------------- -->
<!-- SI no le hago el container fluid al BADY me quedan espacios en los laterales
    y a la hora de verlo en el movil sale un scroll bar abajo-->
<body class="container-fluid">

<div class="container">     
    <div class="row" style="padding-top: 10px">

        @include('layouts.navBars.mainNavBar')

        <!-- ----------------------MAIN-PANEL------------------ -->
        <div class="panel" style="box-shadow: 0 0 15px 0 black;">
            <!--<img src="{{url('/images/flowering-field-and-blue-sky-website-header.jpg')}}"class='img-responsive'/>
            <div id="app">-->
                   
                <!-------------CONTAINER-WRAPPER----------------------->
                <!-- Esto va a mantener todo el contenido junto
                    con el side menu ------------>
                <div class="container">
                    <div class="row">

                        <!-------1------CONTENT------------------------->
                        <div class="col-md-9">
                            <!--La directiva (section) define una sección de contenido, mientras que la directiva (yield) es usada para mostrar el contenido de una sección específica
                            Es decir aqui se va a mostra el contenido de la seccion CONTENT de cualquiera de mis paginas. Solo tengo que poner la etiqueta CONTENT y el codigo-->

                            @include('layouts.tabs.videoTab')
                            
                            @yield('alerts')

                            @yield('searchWords')
                            
                            @yield('content')
                        </div>
                        <!---------------CONTENT------------------------->

                        <!--------2-----------SEARCH BARS---------------------------->
                        <!--- Esto lo incluyo aqui porque se muestra en todas las vistas-->

                        @include('layouts.searchBars.videoBar') 
                        <!-------------------/SEARCH BARS---------------------------->

                        <!--------3------------PANEL GROUP--------------------------->
                        <div class="panel-group col-md-3">                                                       
                            <div class="panel panel-default">
                                <div class="panel-body">    
                                    @include('layouts.sideBars.videoSideBar')
                                    <!--Aveces solo la importacion de STACK en includes solo funcoina si le tramos el stack justo abajo, no se porque-->
                                    @stack('styles')
                                </div>
                            </div>

                        </div> 
                        <!--------------------------------/PANEL GROUP--------------->
                        
                    </div>
                </div>
                <!-------------/CONTAINER-WRAPPER----------------------->
        </div>
        <!-- ----------------------/MAIN-PANEL------------------ -->

            <!----------------------FOOTER-------------------------------------->     
            <footer class="col-md-8 col-md-offset-1"">

                <hr/>
                Curso de preparacion de laravel Mauro Cespedes 2020
            </footer>
         

            <!----------------------/FOOTER-------------------------------------->
    </div>
</div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>