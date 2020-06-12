<!--Estos on los botones del TAB-->
<ul class="nav nav-tabs" style="padding-top: 10px">

    @if (Auth::guest())
        <li class="active"><a href="{{route('welcome')}}"><span class="glyphicon glyphicon-home"></a></li>

        <li class="active"><a  href="{{route('audios')}}">Atrás <span class="glyphicon glyphicon-triangle-left"></a></li>
    @else
        <li class="active"><a href="{{route('welcome')}}"><span class="glyphicon glyphicon-home"></a></li>

        <li class="active"><a  href="{{route('audios')}}"><span class="glyphicon glyphicon-triangle-left"></a></li>

        <li><a href="{{route('createAudio')}}"> <span class="glyphicon glyphicon-circle-arrow-up"></span> Subir Audio</a></li>
    @endif


</ul>
<!---------------TABS------------------------------>
<!-- todas las TABS estaran dentro de un COL-MD-10-->
<div class="tab-content">
    <!--------HOME---------->
    <div id="home" class="tab-pane fade in active">
        <!-- Meterle informacion de videos-->
    </div>
</div>
