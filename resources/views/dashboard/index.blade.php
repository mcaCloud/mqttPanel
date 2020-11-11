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

				<div>
					 <p> Ya {{Auth::user()->created_at->diffForHumans()}}</p>
            <p>Bienvenido <strong> {{Auth::user()->completeName()}}!.</strong></p>
				</div>

<!------------------------------------------------>
<!---------------SWITCHES------------------------>
<!------------------------------------------------>
    <h2>Toggle Switch</h2>

    <!-------- Switch 1------------>
    <div class="card bg-primary text-white col-md-3 shadow p-4 mb-4 bg-white">
      <div class="card-body">
        <label class="switch">
          <!-- Al final de todo es un check box que se marca o note
              Lo primero que voy a hacer asignarle un ID para poder conectarlo con el codigo en JS
              Tambien tengo que captura el valor cuando le hacen CLICK
              Entonces implemento la propiedad de ONCHANGE
              Cuando alguien hace click sobre el input se ejecuta la funcion que yo le indique
              Recordar siempre abrir y cerra parentesis
          -->
          <input id="input_led1" onclick="process_led1()" type="checkbox">
            <span class="slider round"></span>
        </label>
      </div>
    </div>
    <!-------- /Switch 1------------>

      <!-------- Switch 2------------>
      <div class="card bg-primary text-white col-md-3 shadow p-4 mb-4 bg-white">
        <div class="card-body">
          <label class="switch">
            <!-- Al final de todo es un check box que se marca o note
                Lo primero que voy a hacer asignarle un ID para poder conectarlo con el codigo en JS
                Tambien tengo que captura el valor cuando le hacen CLICK
                Entonces implemento la propiedad de ONCHANGE
                Cuando alguien hace click sobre el input se ejecuta la funcion que yo le indique
                Recordar siempre abrir y cerra parentesis
            -->
            <input id="input_led2" onclick="process_led2()" type="checkbox">
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
    <!-- El card-deck es para que alla espacio entre las cards-->
    <div class="card-deck">
      <!------------ erste--------------->
      <div class="card col-md-3 shadow p-4 mb-4 bg-white ">
        <!-----BODY--->
        <div class="card-body" >
            <!-- Trabajo todo lo importante dentro del titulo del card-->
            <h4 class="card-title">
              <div class="row">
                <!--Aislo el Icono para que se me alinie de forma independiente -->
                <div class="md-4">
                  <i class="fas fa-adjust" style="width:100%"></i>
                </div>

                <div class="md-6">
                    <!--Aislo el número que voy a utilizar para conectar con el MQTT
                    Es muy importante siempre aislar el numero que represente el valor entre etiquetas
                    Asi le puedo agregar el identificador ID
                    El ID va a servir para que yo desde el JS pueda llamarlo e identificarlo
                    el nombre me lo invento yo para saber a que se refiere-->
                    <!-- Dejo dos rayitas par indicarle al usuario que si los ve es que
                    aún no hay datos-->
                    <b id ="display_temp1"> -- </b>
                    <span class="text-sm">c</span>
                </div>
              </div>
            </h4>
            <!--Estos son datos adicionales que desee trabajar o agregar al card-->
            <p class="card-text">Temperatura 1 </p>
            <a href="#" class="btn btn-primary">Ver detalles</a>
        </div>
        <!-----/BODY--->
      </div>
      <!------------ /erste--------------->

      <!------------ zweitte--------------->
      <div class="card col-md-3 shadow p-4 mb-4 bg-white ">
        <!-----BODY--->
        <div class="card-body" >
            <!-- Trabajo todo lo importante dentro del titulo del card-->
            <h4 class="card-title">
              <div class="row">
                <!--Aislo el Icono para que se me alinie de forma independiente -->
                <div class="md-4">
                  <i class="fas fa-adjust" style="width:100%"></i>
                </div>

                <div class="md-6">
                    <!--Aislo el número que voy a utilizar para conectar con el MQTT
                    Es muy importante siempre aislar el numero que represente el valor entre etiquetas
                    Asi le puedo agregar el identificador ID
                    El ID va a servir para que yo desde el JS pueda llamarlo e identificarlo
                    el nombre me lo invento yo para saber a que se refiere-->
                    <b id ="display_temp2"> -- </b>
                    <span class="text-sm">c</span>
                </div>
              </div>
            </h4>
            <!--Estos son datos adicionales que desee trabajar o agregar al card-->
            <p class="card-text">Temperatura 2 </p>
            <a href="#" class="btn btn-primary">Ver detalles</a>
        </div>
        <!-----/BODY--->
      </div>
      <!------------ /zweitte--------------->

      <!------------ dritte--------------->
      <div class="card col-md-3 shadow p-4 mb-4 bg-white ">
        <!-----BODY--->
        <div class="card-body" >
            <!-- Trabajo todo lo importante dentro del titulo del card-->
            <h4 class="card-title">
              <div class="row">
                <!--Aislo el Icono para que se me alinie de forma independiente -->
                <div class="md-4">
                  <i class="fas fa-adjust" style="width:100%"></i>
                </div>

                <div class="md-6">
                    <!--Aislo el número que voy a utilizar para conectar con el MQTT
                    Es muy importante siempre aislar el numero que represente el valor entre etiquetas
                    Asi le puedo agregar el identificador ID
                    El ID va a servir para que yo desde el JS pueda llamarlo e identificarlo
                    el nombre me lo invento yo para saber a que se refiere-->
                    <b id ="display_temp3"> -- </b>
                    <span class="text-sm">c</span>
                </div>
              </div>
            </h4>
            <!--Estos son datos adicionales que desee trabajar o agregar al card-->
            <p class="card-text">Temperatura 3 </p>
            <a href="#" class="btn btn-primary">Ver detalles</a>
        </div>
        <!-----/BODY--->
      </div>
      <!------------ /dritte--------------->
  </div>
<!------------------------------------------------>
<!--------------- /MONITORS------------------------>
<!------------------------------------------------>
</div>



<!------------------------------------------------------------------------------------------------------------------->
<!-------------                 JAVESCRIPT                                                              ------------->
<!------------------------------------------------------------------------------------------------------------------->


<!----------------------------------------------------------->
<!------------------------JS SCRIPTS MQTT-------------------->
<!----------------------------------------------------------->

<!--Voy a escribir aqui los scripts del MQTT porque en el layout principla
están tambien los del navigation bar y se me puede confundir. ENtonces mejor
segmentarlo de esta forma.-->

<!-- Primero escribo la librería-->
<!-- Ya importamos la libreria de JQUERY a lso queries del header-->
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js" type="text/javascript"></script>
<script type="text/javascript">
/*
********************************************************************************************
************* FUNCIONES **********************
********************************************************************************************
*/
/*
Aqui agrego todas las funciones que no tengan que ver directamente con la conneción de MQTT
La conneccion casi que queda igual en todos los archivos.
Estos son los procesos que voy a estar tocando mucho más

//Aqui ya utilizo la librería de JQUERY
// # significa que voy a acceder a un ID ya sea para crearlo o modificarlo
//.html significa que quiero acceder al html que contiene esas etiquetas.
//El ejemplo de abajo ya me actualiza el valor del ID display_temp1
        //$("#display_temp1").html("77")
*/


/* ********************************************* */
/*          ACTUALIZAR VALORES                   */
/* ********************************************* */

/*
  Ahora me voy a crear un función que me actualice los tres valores al mismo tiempo
  Esto para maximizar la eficiencia del Broker y evitar recargar las peticiones
  Yo le pongo el nombre que quiera a la funcion
*/
//La funcion recibe los tres valores separados por una coma
//De donde sacamos los valore? Pues posteriormente los vamos a recojer de la conneccion MQTT
//Los valores me llegaran como string por la funcion msg.string del mqtt
function update_values (temp1,temp2,temp3){
  // # significa que voy a acceder a un ID ya sea para crearlo o modificarlo
  //.html significa que quiero acceder al html que contiene esas etiquetas.
  //Sea lo que sea que entre por temp1 se reemplazara en el codigo html. Asi con los otros
  $("#display_temp1").html(temp1);
  $("#display_temp2").html(temp2);
  $("#display_temp3").html(temp3);
}
/*Ahora si la funcion de arriba se carga en memoria pero no se ejecuta hasta que
alguien la llame. ENtonces ahora llamo a esa funcióno
Aqui utilizamos comillas dobles porque son STRINGS. Hay que recordar. Cada uno
separado por un a coma.
        update_values("","","");
La funcion la vamos llamar desde otra funcion que obtiene los datos de MQTT.
*/

/* ********************************************* */
/*          PROCESA MENSAJES MQTT                */
/* ********************************************* */

// Para que esta funcion pueda obtener la info de MQTT me tiene que recibir el TOPIC y el mensaje
//en la funcion de   client.on('message', (topic, message) llamo a esta funcion y le paso los dos parametros.
function process_msg (topic, message){
  /*Ahora hago una comprobacion con IF de que valores me llegan.
  Voy a intentar recibir todos los valores juntos, para optimizar el proceso.
  Pero si se quiere se puede hacer un IF por cada topico tambien.
  Asi le ayudo al broker a no tener tanta carga*/

  //Para ello creo un array que se llame values para que reciba todos los valores que yo desee.
  // Puedo mandar todos los valores un un solo mensaje
  if (topic=="values") {
    //Creo una variable nueva para que me guarde message.toString
    //message.toString es un objeto con un metodo que extrae el mensaje propiamente.
    // Entonces la nueva variable guarda el mensaje ya extraido. Es la que seguire utilizando.
    var msg = message.toString();
    //Lo que llega son valores separados por coma.
    //Tengo que extraerlos dividirlos y guardarlos por aparte.
    //Entonces creo una nueva variable para que me divida los valores.
    //JS tiene un metodo que se llama split(). Entonces le paso lo que divide los valores
    //En este caso es una coma
    var sp = msg.split(",");
    //Entonces esto se me convierte en un array
    //Ahora puedo acceder a cada posicion de ese array para saber cada uno de los valores
    var temp1 = sp[0];
    var temp2 = sp[1];
    var temp3 = sp[2];

    //Ahora si llamo a la funcion de actualizar valores y le paso los valores del BROKER
    update_values(temp1, temp2, temp3);
  }
}

/* ********************************************* */
/*         Toogle buttons                        */
/* ********************************************* */

/*Al final lo que se necesita hacer es capturar el estado del interruptor
  Cuando este prendido y cuando este apgado.
  El nombre de la funcion me lo invento yo pero es el mismo que tiene que ir en el
  codigo html dentro de la propiedad onchange
*/
function process_led2(){
  //Recordar que para llamar a la libreria de JQUERY se comienza con $
  //Después le indicamos el ID que vamos a utilizar, es decir el ID del toogleButton.
  //Si el input del led1 esta encendido (checked) entonces:
  if ($('#input_led2').is(":checked")) {
    //console.log("Encendido ");
    // Esta es la forma de publicar un menssage bajo un tópico
    //Primero incluyo el tópico y despues el mensaje
    //El tópico es el que lo creo yo, los que se suscriban vana tener acceso a los mensajes
    client.publish('led2', 'ON', (error) =>{
    //Ahora como estoy desarrollando es bueno revisar por pantalla
   //Pero despues todos los console.log se tienen que eliminar.
   //Asi no se expone informacion privada en el Internet
        //console.log(error || 'Mensaje enviado!!');
      })

  }else{
    //Ahora lo mismo. Si el estado es apagado envío un mensaje.
    //console.log("Apagado ");
    client.publish('led2', 'OFF', (error) =>{
        //console.log(error || 'Mensaje enviado!!');
      })
  }
}
function process_led1(){
  //Recordar que para llamar a la libreria de JQUERY se comienza con $
  //Después le indicamos el ID que vamos a utilizar, es decir el ID del toogleButton.
  //Si el input del led1 esta encendido (checked) entonces:
  if ($('#input_led1').is(":checked")) {
    console.log("Encendido" + topic);
    // Esta es la forma de publicar un menssage bajo un tópico
    //Primero incluyo el tópico y despues el mensaje
    //El tópico es el que lo creo yo, los que se suscriban vana tener acceso a los mensajes
    client.publish('led1','ON', (error) =>{
    //Ahora como estoy desarrollando es bueno revisar por pantalla
   //Pero despues todos los console.log se tienen que eliminar.
   //Asi no se expone informacion privada en el Internet
        console.log(error || 'Mensaje enviado!!');
      })

  }else{
    //Ahora lo mismo. Si el estado es apagado envío un mensaje.
    console.log("Apagado ");
    client.publish('led1','OFF', (error) =>{
        console.log(error || 'Mensaje enviado!!');
      })
  }
}
/*
********************************************************************************************
************* CONNEXION *********************
********************************************************************************************
Hago un diferencia marcada entre donde tengo los datos de la conneccón MQTT y el resto del código
De esta manera cuando el código crezca podemos ubicar las partes de manera más simple.
*/
// connect options
	    const options = {
      		connectTimeout: 3000,

          // Authentication
          //Por razones obvias no incluyo las claves en este archivo.
          //Actualizar codigo en el servidor.
      		 clientId: 'emqx',
      		 username: 'web_client',
      		 password: '121212',

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
     /*
     ***********************************************
     ********* GENERAL CONEXION TO BROKER **********
     ***********************************************
     */
     /* ****************************************** */
     /*            CONNECT                         */
     /* ****************************************** */

     //Lo primero que va a hacer l broker es conectarse
     //Imprimo un mensaje en pantalla para saber que estoy conectado
	    client.on('connect', () => {
        //El console log esta bien dejarlo mientras desarrollamos
        //Despues es mejor quitarlo para no revelar informacion sensible.
    		console.log('connect success exito')

        /* ***************************************** */
        /*              subscribe                   */
        /* ***************************************** */
        //Despues me tengo que suscribir al topico que deseo escuchar
        //Ya lo de QoS lo iré desarrollando después
        client.subscribe('values',{ qos: 0 }, (error) => {
          if (!error) {
            console.log('Suscripción exitosa')
          }else{
            console.log('Suscripción fallida')
          }
        })
        /* ***************************************** */
        /*              publish                      */
        /* ***************************************** */

	   })

       /* ****************************************** */
       /*            RE-CONNECT                       */
       /* ****************************************** */

	    client.on('reconnect', (error) => {
        //El console log esta bien dejarlo mientras desarrollamos
        //Despues es mejor quitarlo para no revelar informacion sensible.
    		console.log('reconnecting:', error)
	     })
       /* ****************************************** */
       /*            ERROR                           */
       /* ****************************************** */
	    client.on('error', (error) => {
        //El console log esta bien dejarlo mientras desarrollamos
        //Despues es mejor quitarlo para no revelar informacion sensible.
    	        console.log('Connect Error:', error)
	    })
      /*
      ***********************************************
      ***************** MESSAGES ********************
      ***********************************************
      */
      //Este es un listener que que esta pendiente para ver si sucede el evento ´message´
      //Si el evento mensaje ocurre, la funcion nos entrega en bandeja el topico y el mensaje
      //Gracias a esta funcion yo puedo acceder en todo momento a topico como a mensaje
      client.on('message', (topic, message) => {
        //El console log esta bien dejarlo mientras desarrollamos
        //Despues es mejor quitarlo para no revelar informacion sensible.
        //El mensaje se convierte a una cadena de string cunado llega
    		console.log('mensaje recibido bajo topico: ', topic, '-->', message.toString())
        //Aqui llamo a la funcion de process_msg y le paso lo que me este llegando como mensaje y topico
        process_msg(topic, message);
	     })

	</script>
@stop
