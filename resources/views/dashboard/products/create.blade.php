@extends('dashboard.layout')
@section('title','Crear servicio')

@section('content')
    <h3 class="page-title">Nuevo servicio</h3>

    <div class="card shadow mb-6">

        <div class="card-header py-3">
            Crear nuevo trámite bajo el servicio de <strong>{{$folderName->name}}</strong>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 form-group">

                    <!-- ----FORMULARIO ----- -->
                    <!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
                    <form action="{{ route('dashboard::productos.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
                            <label for="title">Titulo</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" />
                        </div>

                        <!--Este es el parametro que utilizo para que el ID de la categoria lo lea el controlador y me lo guarde en la BD.-->
                        <input type="hidden" class="form-control" id="title" name="folder" value="{{$folderName->id}}" />

                        <button type="submit" class="btn btn-success">
                            CREAR
                        </button>
                    </form>
                    <!-- ----/FORMULARIO ----- -->
                </div>
            </div>
            
        </div>
    </div>

@stop