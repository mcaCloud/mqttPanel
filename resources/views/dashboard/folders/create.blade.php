@extends('dashboard.layout')
@section('title','Crear Folder')

@section('content')
    <h3 class="page-title">Folders</h3>

    <div class="card shadow mb-6">

        <div class="card-header py-3">
            Crear nueva carpeta
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 form-group">

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
                            <label for="title">Titulo</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" />
                        </div>

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