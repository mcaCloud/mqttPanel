@extends('dashboard.layout')
@section('title','Inicio')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/panelMqttDashboard.css') }}">
@endpush

@section('content')


<!----------------------------------------------------------->
<!------------------------PAGE------------------------------>
<!----------------------------------------------------------->

	<div class="page">

		<div class="timeline__post">
				<div class="timeline__content">
					 <p> Ya {{Auth::user()->created_at->diffForHumans()}}</p>
            <p>Bienvenido <strong> {{Auth::user()->completeName()}}!.</strong></p>
				</div>
	  </div>

<!------------------------------------------------>
<!---------------SWITCHES------------------------>
<!------------------------------------------------>
    <h2>Toggle Switch</h2>
    <!-------- Switch 1------------>
    <div class="row">
      <div class="card col-md-3">
        <div class="card-body">
          <label class="switch">
            <input type="checkbox">
              <span class="slider"></span>
          </label>
        </div>
      </div>
      <!-------- /Switch 1------------>

      <!-------- Switch 2------------>
      <div class="card bg-primary text-white col-md-3">
        <div class="card-body">
          <label class="switch">
            <input type="checkbox">
              <span class="slider round"></span>
          </label>
        </div>
      </div>
      <!-------- /Switch 2------------>
    </div>
<!------------------------------------------------>
<!---------------/SWITCHES------------------------>
<!------------------------------------------------>


<!------------------------------------------------>
<!--------------- MONITORS------------------------>
<!------------------------------------------------>
    <h2>Monitors</h2>

    <div class="row">
      <div class="card col-md-3">
        <div class="card-body">
          <h4 class="card-title"><i class="fas fa-adjust" style="width:100%"> 12 </i></h4>
          <p class="card-text">Some example text </p>
          <a href="#" class="btn btn-primary">See Profile</a>
        </div>
      </div>
      <br>

      <div class="card col-md-3">
        <div class="card-body">
          <h4 class="card-title"><i class="fas fa-arrow-alt-circle-up" style="width:100%"> 12 </i></h4>
          <p class="card-text">Some example text </p>
          <a href="#" class="btn btn-primary">See Profile</a>
        </div>
      </div>
<!------------------------------------------------>
<!--------------- /MONITORS------------------------>
<!------------------------------------------------>

</div>
<!----------------------------------------------------------->
<!------------------------PAGE------------------------------>
<!----------------------------------------------------------->

<!----------------------------------------------------------->
<!------------------------JS SCRIPTS MQTT-------------------->
<!----------------------------------------------------------->

<!--Voy a escribir aqui los scripts del MQTT porque en el layout principla
están tambien los del navigation bar y se me puede confundir. ENtonces mejor
segmentarlo de esta forma.-->

<!-- Primero escribo la librería-->
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js" type="text/javascript"></script>
<script type="text/javascript">
      // connect options
	    const options = {
      		connectTimeout: 3000,

                // Authentication
      		 clientId: 'emqx',
      		 username: '',
      		 password: '',

      		 keepalive: 60,
      		 clean: true,
	      }

	    //YA intalle el cetificado y ahora entonces puedo utilizar el protocolo WSS
	    const WebSocket_URL = 'wss://gaia2-0.com:8094/mqtt'

	    //Aqui llamo a la libreria que llame al principio
	    //La libreria la estoy llamando desde una pagina, pero la puedo descargar al servidor para evitar problemas por si se cae la pagina
	    //A la libreria le paso dos parametros
            //A donde se tiene que conectar : WebSockets_URL. Es la variable que iniciamos arriba
            // Las opciones que seteamos mas arriba. Es el array con los parametros de coneccion

	    const client = mqtt.connect(WebSocket_URL, options)

           // ///////////EVENTOS ////////////////
	   // Estos no los defino yo, vienen predefinidos por la libreria
	   //Basicamente es lo que paso en caso de conectarme, Errores o reconeccion

	    client.on('connect', () => {
    		console.log('connect success exito')
	     })

	    client.on('reconnect', (error) => {
    		console.log('reconnecting:', error)
	     })

	    client.on('error', (error) => {
    	        console.log('Connect Error:', error)
	    })

	</script>
@stop
