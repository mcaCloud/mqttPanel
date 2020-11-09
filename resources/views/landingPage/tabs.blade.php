
<!--Estos on los botones del TAB-->
<ul class="nav nav-tabs" style="padding-top: 10px">
    <!--You can activate a tab or pill navigation without writing any JavaScript by simply specifying data.toggle="tab" or data.toggle="pill" on an element. Adding the nav and nav-tabs classes to the tab ul will apply the Bootstrap tab styling.-->
    <li class="active"><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-home"></a></li>
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
    <div id="home" class="tab-pane active">

        @push('styles')
            <link href="{{ asset('css/carrousel.css') }}" rel="stylesheet">
        @endpush

        <!-- Agregar el contenido del tab o hacer referencia al contenido -->
        @include('landingPage.common.tabs.home')

    </div>

    <!--------Desarrollo Web---------->
    <div id="equipo" class="tab-pane">
        <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>
    <!--------Servicios---------->
    <div id="servicios" class="tab-pane ">
        <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>

    <!--------Hablemos---------->
    <div id="hablemos" class="tab-pane ">
        <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>

    <!--------citas---------->
    <div id="citas" class="tab-pane ">
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>
        <!--------Noticias---------->

    <div id="noticias" class="tab-pane ">
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>
        <!--------Cursos---------->
    <div id="cursos" class="tab-pane ">
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>
        <!--------Precios---------->
    <div id="precios" class="tab-pane fade">
         <!-- Agregar el contenido del tab o hacer referencia al contenido -->

    </div>
</div>
<script type="text/javascript">

  $(function () {
    $('#myTab a:last').tab('show');
  })
</script>
