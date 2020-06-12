
@extends('auth.layout')

@section('title','Acceso usuarios')
@section('content')

<div class="row justify-content-center" style>

  <div class="col-xl-10 col-lg-12 col-md-9">

    <!---------------------CARD--------------------->
    <div class="card o-hidden border-0 shadow-lg my-5">

      <!---------------Card-Body-------------------->
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">

          <div class="col-lg-12">
            <!-- p (padding) pt(pading top) pb(padding bottom)-->
            <div class="p-5">

              <!-- -------Imagen-------------->
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">
                  <img src="/img/logo.png" class="responsive-img">
                </h1>
              </div>
              <!-- -------/Imagen-------------->

              <!-- ---------- FORM -------------->
              <form method="POST" action="{{ route('login-customer') }}" class="user" id="formLogin">
                {{ csrf_field() }}

                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user" placeholder="correo electrónico">
                </div>

                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-user" placeholder="contraseña">
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Iniciar Sesión
                </button>
                <!--Esto es para que me aparezcan los errores cuando
                    ha exedido el numero de attempts
                    Deberia de funcionar desde el TRAIT pero no lo hace aún
                    Esto es un override a la funcion de sendFailedLoginResponse-->
                @if (count($errors))

                  @if (count($errors) == 1 && in_array(__('auth.throttle'), $errors->get('email')))
                        <p>@lang('auth.throttle')</p>
                  @else
                    <ul>
                      @foreach ($errors->all() as $error)
                        {{ $error }}
                      @endforeach
                    </ul>
                  @endif
                @endif 
              </form>
              <!-- ---------- /FORM -------------->
              <hr>
              <div class="text-center">
                <a class="small" href="{{route('password.request')}}">Olvidaste tu contraseña?</a>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <!---------------Card-Body-------------------->
    </div>
    <!---------------/Card--------------------------->

  </div>
</div>

@stop

@section('js-validation')
    {!! JsValidator::formRequest(\App\Http\Requests\LoginRequest::class, '#formLogin') !!}
@stop