@extends('dashboard.layout')
@section('title','Servicios')

@section('content')

      <p>
        <!-- Como la ruta esta en DASHBOARD no debemos olvidar ponerlo porque sino no encuentra la ruta-->
        <p>
        <!-- Esto es para que no nos pongo bullt points-->
        <ul style="list-style: none;">

            <li>
                <a href="{{route('dashboard::offices.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
                </a>

                <span class="separador">| </span>

                <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
                </a> 

                <span class="separador">| </span>

                <a href="#" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Borrados
                </a> 
            </li>  

        </ul>
        </p>
    <div class="row">
    <div class="col-md-12" style="padding: 10px">
    <div><h2>{{$office->name}}</h2>
      <hr>
      <div class="col-md-12">


        <!------ DESCRIPCION DEL VIDEO------>
        <div class="panel panel-success video-data ">
          <div class="panel-heading class">

            <div class="panel-title">
              <!-- Aqui voy a utilizar un helper para poder formatear las fechas. Utilizo el helper y el metodo dentro del helper, y finalmente le paso mi fecha para formatear-->
             
            </div>
            
          </div>
          <div class="panel-body">
            {{$office->description}}
          </div>
        </div>


      </div>
    </div>
  </div>
</div>
@endsection