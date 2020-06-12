<!--Estos on los botones del TAB-->
<ul class="nav nav-tabs" style="padding-top: 10px">
    <li class="active"><a href="{{route('index')}}"><span class="glyphicon glyphicon-home"></a></li>
    <li><a data-toggle="tab" href="#equipo">Equipo</a></li>
    <li><a data-toggle="tab" href="#servicios">Servicios</a></li>
    <li><a data-toggle="tab" href="#hablemos">Hablemos ahora</a></li>
    <li><a data-toggle="tab" href="#citas">Pide tu cita</a></li>
    <li><a data-toggle="tab" href="#noticias">Noticias</a></li>
    <li><a data-toggle="tab" href="#cursos">Cursos</a></li>
    <li><a data-toggle="tab" href="#precios">Precios</a></li>
</ul>
<!---------------TABS------------------------------>
<!-- todas las TABS estaran dentro de un COL-MD-10-->
<div class="tab-content">
    <!--------HOME---------->
    <div id="home" class="tab-pane fade in active">

        @push('styles')
            <link href="{{ asset('css/carrousel.css') }}" rel="stylesheet">
        @endpush

        <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.home')

    </div>

    <!--------Desarrollo Web---------->
    <div id="equipo" class="tab-pane fade in active">
        <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.equipo')
    </div>
    <!--------Servicios---------->
    <div id="servicios" class="tab-pane fade">  
        <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.servicios')
    </div>

    <!--------Hablemos---------->
    <div id="hablemos" class="tab-pane fade">        
        <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.hablemos')
    </div>

    <!--------citas---------->
    <div id="citas" class="tab-pane fade">        
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.citas')
    </div>
        <!--------Noticias---------->
    <div id="noticias" class="tab-pane fade">        
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.noticias')
    </div>
        <!--------Cursos---------->
    <div id="cursos" class="tab-pane fade">        
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.cursos')
    </div>
        <!--------Precios---------->
    <div id="precios" class="tab-pane fade">        
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('.landingPage.common.tabs.precios')
    </div>
</div>
