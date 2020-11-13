//Lo primero que hago es llamar las librerias de MySql y mqtt
//Creo una variable para que me guarde la peticion de requerir esas librerias
var mysql = require('mysql');
//Para MQTT vamos a utilizar la libreria que me recomienda EMQX, aunque tambien podriamos utilizar -Paho mqtt-
var mqtt = require('mqtt');
//Si ejecuto - node index.js - me da error porque aun no he instalado las librerias
//Procedo a installar los modulos de NodeJS
//Con npm lo intallo dentro de la carpeta para trabajar solo para este proyecto
//Hay formas de ejecutarlo de manera global tambien.
        // npm install mysql
        //npm install mqtt
// Es fundamental iniciar el projecto con NPM para que genere el package.json
//No basta con copiar y pegar los datos. Sino nos da error a la hora de instalar modulos

// ********************************************
// ************  MySql Credenciales ***********
// ********************************************

//Utilizo el metdo - createConnection
//Dentro de las llaves escribo los datos de conexion
var con = mysql.createConnection({
  // Por algun motivo si no le pongo el debug no me entrega la informacion de la consulta
  //debug: true,
  //Como la DB esta funcionando en el mismo servidor pongo local localhost
  host: "localhost",
  user:"mcespede",
  password:"$!KiwP$ratwXzw249!",
  database:"gaiaIOT",
});

// *****************************************************
// **************  CREAR CONEXION MySql ****************
// *****************************************************

//Con la conexion creada es hora de conectarme
//Uso function(err)-> por si hay un error que me lo diga
con.connect(function(err){
  //Hay que manejar los errores con un if simple
  //Si hay error tirame el error
  if (err) throw err;
  //Imprimo un mensaje para saber que ya estoy conectado
  console.log("Conexion exitosa");

  // **************  CONSULTA **********************
  //Aqui ya estamos conectados entonces puedo ejecutar una consulta
  //Creo una variable local y preparo la consulta
  //Esta consulta dice seleccionamos todas las consultas de la tabla users
  //El WHERE 1 solo significa que lo seleccione de donde esta todo. Todas columnas y todas las filas
  var query = "SELECT * FROM users WHERE 1";
  // Tomamos la conexion que habiamos creado con el metodo query para ejecutar la conuslta
  //Le paso la consults -query-
  // La funcion no da errores si los hay, los resultados y los compos solicitados - fields -
  con.query(query, function(err, result, fields){
    if (err) throw err;
    //Los resultados se ponen dentro del if
    //So existen resultados imprimo los resultados. Forma bonita de hacerlo
    if (result.length > 0 ){
      //Esto seria un array con todas la filas y todo lo que encuentreSS
      console.log(result);
    }
  });

});

// ********************************************
// ************  MQTT Credenciales ************
// ********************************************
//Creo un objeto mediate una estructura JSON para que me guarde las Credenciales
//Siempre se crean entre llaves
//Siempre es lo mismo nada mas se cambian las credenciales de acuerdo al proyecto en el que se este
var options = {
  //La ventaja de este puerto es que nos conectamos directo por TCP
  port: 1883,
  //La ventaja es que NodeJS funciona en el mismo servidor donde tenemos el broker
  host: 'gaia2-0.com',
  //Creo un client ID y mediate una funcion le concateno un numero Random
  //Para tener siempre clientes distintos pero con el mismo inicio. De esa forma es mas facil de ver
  clientId: 'access_control_server_' + Math.round(Math.random() * (0-10000)*-1),
  //Este es el usuario de de MQTT que cree en la DB
  username: 'web_client',
  password: '121212',
  //Cada tanto envio algo para que no se caiga la coneccion
  keepalive: 60,
  reconnectPeriod: 1000,
  protocolId: 'MQIsdp',
  protocolVersion: 3,
  //NO quiero que nadie me guarde nada
  clean: true,
  //Este es el Data Set
  encoding: 'uft8'
  //un4B?8n6

};

// ********************************************
// ************  MQTT CONEXION  ***************
// ********************************************
//Creo el cliente de mqtt. Le paso como parametro el dominio y el objeto -> options que cree más arriba.
var client = mqtt.connect("mqtt://gaia2-0.com",options);

// Igual que en JS voy a tener funciones que se van a disparar ante diferentes eventos

// **************  SI SE CONECTA **********************
client.on('connect',function(){
  //UN mensaje de consola para saber que si me conecté
  //Es importante saber que esta pasando si no vamos a ciegas
  console.log("Conexión a MQTT exitosa");
  //Me voy a conectar a todos los topicos
  //Me podria conectar a un topico determinado dentro del arbol -> edificio1/#
  //Casi nunca vamos a Suscripcion a todos los topicos. Esto es por ejemplo
  client.subscribe('+/#', function(err){
    //Cunado se realiza la subcriccion al topico deseado
    console.log("Suscripcion exitosa!!");
  });
})

// **************  SI RECIBE UN MSJ **********************
//Cuando recibe mensaje
//Esta funcion es exactamente igual de lo que hacemos en el dashboard
// La funcion ya me pasa el topico y el mensaje
client.on('message',function(topic,message){
  //De esta forma imprimo el topico y el mensaje y lo imprimo en pantalla
  console.log("Mensaje recibido desde ->" + topic + "mensaje->" + message.toString());
  //Cuando recibo los valores los quiero grabar en la base de datos
  if (topic == "values") {
    //********SEPARO VALORES ******
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

    //******CONSULTA INSERTAR**********
    //La query la grabo como un string corriente. En este caso quiero insertar filas en la DB
    //VALUES le inserto la informacion ya separada . Pero como la consulta esta entre comillas lo tengo que concatenar.-> "+temp1+"
    var query = "INSERT INTO `gaiaIOT`.`data`(`data_temp1`, `data_temp2`, `data_volts`) VALUES ("+ temp1 +","+ temp2 +","+ temp3 +");";
    //Le paso la query al metodo. SIEMPRE SE HACE ASI
    //De esta forma ejecuto la consulta anterior
    con.query(query, function (err, result, fields) {
      //Los resultados se ponen dentro del if
      if (err) throw err;
      // Si la consulta funcionó hago un log para ver la informacion
      console.log("Fila insertada correctamente");
    });
  }
});

// ************************************************************************
// **********************   FIXED   ***************************************
// ************************************************************************
// ************************************************************************
// ********** Mantener conexion abierta con MySql *************************
// ************************************************************************
// Si no hay consultas por un cierto perido de tiempo MySql nos cierra la Conexion. Entonces tendriamos que conectarme antes
//de hacer cada consulta. Pero eso significa conectarnos por cada consulta y aveces son muchisimas. NO GOOD
//Hay un WORK ARROUND que funciona
// -setInterval- de JS me permite ejecutar fuciones cada cierta cantidad de tiempo
// -5000- cada 5 segundos me ejecuta lo que tenga en el medio
setInterval(function () {
  // Consulta basica pero que me mantiene la consulta abierta cada 5 segundos

  //******CONSULTA**********
  //La query la grabo como un string corriente
  var query = 'SELECT 1 + 1 as result';
  //Le paso la query al metodo. SIEMPRE SE HACE ASI
  con.query(query, function(err, result, fields){
    //Los resultados se ponen dentro del if
    if (err) throw err;
  });

}, 5000);
