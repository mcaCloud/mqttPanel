@extends('dashboard.layout')
@section('title','Crear oficina')
@section('content')
<p>
    <!-- Esto es para que no nos pongo bullt points-->
    <ul style="list-style: none;">

        <li>
            <a href="{{route('dashboard::offices.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
                </a>
            <span class="separador">| </span>

            <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
                </a> 
        </li>  

    </ul>
</p>

<div class="card shadow mb-6">

    <div class="card-header py-3">
            <h3><strong>Crear una nueva oficina</strong></h3>   
    </div>
        
    <div class="card-body">

        <!-- ----FORMULARIO ----- -->
        <!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
        <form action="{{ route('dashboard::offices.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
            <!-- Laravel nos obliga a proteger los formularios con CSRF-->
            {!! csrf_field() !!}

            <!----- MOSTRAR ERRORES------>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <!-- Que recorra cada error y lo muestre en formato de lista. El idioma de los texto se cambia en CONFIG>APP.PHP. Pero necesito crear las carpetas de traducciones en la carpeta LANG -->

                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>               
                </div>
            @endif
            <!----- /MOSTRAR ERRORES------>

            <!-- ----FORM-GROUP 1 ----- -->                       
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="name">Nombre de la oficina</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" />
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="description">Datos generales</label>
                        <textarea type="text" class="form-control" id="description" name="description" value="{{old('description')}}" /></textarea>
                    </div>
                </div>                           
            </div>

            <h3 class=" btn-info" style="text-align: center;">Dirección de la oficina</h3><hr>

            <!-- ----FORM-GROUP 2 ----- -->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <div class="form-group">
                        <label for="street_name">Nombre de la calle</label>
                            <input type="text" class="form-control" id="street_name" name="street_name" value="{{old('street_name')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="form-group">
                        <label for="street_number"># calle</label>
                            <input type="text" class="form-control" id="street_number" name="street_number" value="{{old('street_number')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="form-group">
                        <label for="floor"># piso</label>
                            <input type="text" class="form-control" id="floor" name="floor" value="{{old('floor')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="form-group">
                        <label for="floor_door"># puerta</label>
                            <input type="text" class="form-control" id="floor_door" name="floor_door" value="{{old('floor_door')}}" />
                    </div>
                </div>
                                                                           
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="form-group">
                        <label for="zip_code">zip_code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{old('zip_code')}}" />
                    </div>
                </div>
            </div>

            <!-- ----FORM-GROUP 3 ----- -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="manual_directions">Direcciones manuales</label>
                        <textarea type="text" class="form-control" id="manual_directions" name="manual_directions" value="{{old('manual_directions')}}" /></textarea>
                    </div>
                </div>
            </div>

            <!-- ------------- ----- -->
            <h3 class=" btn-info" style="text-align: center;">Dirección de transporte público</h3><hr>

            <!-- ----FORM-GROUP 3 ----- -->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label for="metro_station_1">Metro</label>
                            <input type="text" class="form-control" id="metro_station_1" name="metro_station_1" value="{{old('metro_station_1')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2">
                    <div class="form-group">
                        <label for="metro_line_1">Línea</label>
                            <input type="text" class="form-control" id="metro_line_1" name="metro_line_1" value="{{old('metro_line_1')}}" />
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label for="metro_station_2">Metro</label>
                            <input type="text" class="form-control" id="metro_station_2" name="metro_station_2" value="{{old('metro_station_2')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2">
                    <div class="form-group">
                        <label for="metro_line_2">Línea</label>
                        <input type="text" class="form-control" id="metro_line_2" name="metro_line_2" value="{{old('metro_line_2')}}" />
                    </div>
                </div>
            </div>

            <!-- ----FORM-GROUP 4 ----- -->
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <div class="form-group">
                        <label for="bus_line">Autobús</label>
                        <input type="text" class="form-control" id="bus_line" name="bus_line" value="{{old('bus_line')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2">
                    <div class="form-group">
                        <label for="bus_line_letter">Letra</label>
                        <input type="text" class="form-control" id="bus_line_letter" name="bus_line_letter" value="{{old('bus_line_letter')}}" />
                    </div>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2">
                    <div class="form-group">
                        <label for="renfe_line">Renfe</label>
                        <input type="text" class="form-control" id="renfe_line" name="renfe_line" value="{{old('renfe_line')}}" />
                    </div>
                </div>
            </div>

            <!-- ------------- ----- -->
            <h3 class=" btn-info" style="text-align: center;">Horarios</h3><hr>

            <!-- ----FORM-GROUP 5 ----- -->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label for="schedule_days">Días laborables</label>
                        <input type="text" class="form-control" id="schedule_days" name="schedule_days" value="{{old('schedule_days')}}" />
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label for="schedule_hours">Horario de atención</label>
                        <input type="text" class="form-control" id="schedule_hours" name="schedule_hours" value="{{old('schedule_hours')}}" />
                    </div>
                </div>
            </div>

            <!-- ------------- ----- -->
            <h3 class=" btn-info" style="text-align: center;">Datos de contacto</h3><hr>

            <!-- ----FORM-GROUP 5 ----- -->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" />
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <!-- ------------- ----- -->
                    <div class="form-group">
                        <label for="phone_number">phone_number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{old('phone_number')}}" />
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <!-- ------------- ----- -->
                    <div class="form-group">
                        <label for="website">website</label>
                        <input type="text" class="form-control" id="website" name="website" value="{{old('website')}}" />
                    </div>
                </div>
            </div>    

            <button type="submit" class="btn btn-success">
                CREAR
            </button>
        </form>
        <!-- ----/FORMULARIO ----- -->           
    </div>
</div>

@stop