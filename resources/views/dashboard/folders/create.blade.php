@extends('dashboard.layout')
@section('title','Crear servicio')

@section('content')
<p>
<!-- Esto es para que no nos pongo bullt points-->
    <ul style="list-style: none;">
        <li>
            <a href="{{route('dashboard::categorias.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
            </a>
            <span class="separador">| </span>

            <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
            </a> 

        </li>  

    </ul>
</p>
<!-------------------------------------------------->
<!-------------------------------------------------->
<!-------------------------------------------------->

<div class="card shadow mb-6">
    <div class="card-header py-3">
        Crear nuevo servicio bajo la categoría de <strong>{{$cathegoryName->name}}</strong>
    </div>
        
    <div class="card-body">
            <div class="col-md-12 col-xs-12 form-group">
                <!-- ----FORMULARIO ----- -->
                <!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
                <form action="{{ route('dashboard::folders.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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

                    <!-- ----FORM-GROUPS ----- -->
                    <div class="form-group">
                        <label for="title">Nombre del servicio</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" />
                    </div>

                    <!--Este es el parametro que utilizo para que el ID de la categoria lo lea el controlador y me lo guarde en la BD.-->
                    <input type="hidden" class="form-control" id="title" name="cathegory" value="{{$cathegoryName->id}}" />

                    <!-- ----FORM-GROUPS ----- -->
                    <div class="form-group">
                        <label class="control-label">Oficina :</label>

                        <!------------------------------------->
                        <!------------------------------------->
                        <!------------------------------------->

                        <!-- NAME es el parametro que paso al controlador con el contenido-->
                        <select name="office_id" id="office" class="select2" multiple="multiple">

                            <option value="">Seleccione una opción...</option>

                                @foreach($offices as $office)

                                    <option value="{{$office->id}}">{{$office->name}}<option>                                       
                                @endforeach
                        </select>
                        <!------------------------------------->
                        <!------------------------------------->
                        <!------------------------------------->

                    </div>

                    <!-- ----FORM-GROUPS ----- -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <label> Estado (Activo / Inactivo) : </label>
                              <input type="checkbox" class="control-label js-switch" name="status" id='status' data-render='switchery'/>
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
</div>

<!-- In your Javascript (external .js resource or <script> tag)
The DOM cannot be safely manipulated until it is "ready". To make sure that your DOM is ready before the browser initializes the Select2 control, wrap your code in a $(document).ready() block. Only one $(document).ready() block is needed per page.-->
<script type="text/javascript">
    $(document).ready(function() {
        $('.offices').select2();
    });
</script>

@stop