@extends('dashboard.layout')

@section('content')

<div class="row">
<div class="col-md-12">
<!------------CARD-------------------------->
 <div class="card">

    <div class="card shadow mb-5">

      <!--------HEADER-------------------->
      <div class="card-header py-3">

        <div class="row col-12">
          <div class="col-6">
            <h6 class="m-0 font-weight-bold text-primary btn-icon-split align-bottom">
		        <!--Tomo la variable del controlador
              Como ya tengo ahi el modelo de USER tomo el metodo para que me saque el nombre completo-->
            	{{$user->completeName()}} </h6>
          </div>
        </div>

      </div>
      <!-------- /HEADER--------------------> 


      <!-------------- BODY--------------------> 
      <div class="card-body">
        <div class="col-md-12">

<!----------------------------------------------------------------->
        <div class="col-md-12">
          <div class="row">
            <!----------------------IMAGE-FORM---------------------------->
            <div class="container-fluid col-md-6">

            <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
              @if(Storage::disk('avatars')->has($user->image))
                <!-- Le concateno a la ruta minitura la imagen que quiero ver-->
                <!-- Aqui estoy utilizando el metodo del UserProfile ('getImage')-->
                <!-- Como segundo parametro la ruta necesita el 'filename', entonces le paso el path de la image que guardé en el metodo update-->
                <!--La quiero centrar entonces utilizo una posicion relativa y 25% hacia la izquierda-->
                <img src="{{url('/miniatura/'.$user->image)}}" class="img-fluid" style="vertical-align: middle;width:80%;height:90%;border-radius: 50%;box-shadow: 0 0 8px rgba(0,0,0,0.8);" />   
              @else
                <img src="{{ URL::to('/') }}/img/avatar.png" alt="logo" class="img-thumbnail"/>
              @endif

            </div>
            <!----------------------/IMAGE-FORM----------------------------->

            <div class="col-6">
             
                  @include('dashboard.users.partials.profileUserForm-1')

            </div>

          </div>
        </div>

<!----------------------------------------------------------------->
          <div class="row">
                        <!-- ----FORMULARIO ----- -->
              <!-- Cuando utilizo ROUTE() uso el nombre de la ruta en el controlador. No importa que cambie el nombre del URL siempore nos va a dirigir a la ruta. En caso de usar URL() tenemos que usar el URL del controlador -->
              <!-- Tengo que pasarle en un array el video ID-->
            <div class="col-12">
              <!--The enctype attribute specifies how the form-data should be encoded when submitting it to the server.-->
              <!--This value is required when you are using forms that have a file upload control-->
              <form method="POST" action="{{route('updateUser',['id'=>$user->id])}}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                {!! csrf_field() !!}

                @include('dashboard.users.partials.profileUserForm-2')

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

                @include('dashboard.common.form_buttons')
                
              </form>
            </div>
          </div>
<!----------------------------------------------------------------->
      </div> 
    </div>
      <!-------------- /BODY-------------------->
  </div>
</div>
<!------------CARD-------------------------->
</div>
</div>
@stop

@section('js-validation')
    {!! JsValidator::formRequest(\App\Http\Requests\UserRequest::class, '#formEditUser') !!}
@stop