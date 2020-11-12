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
// ************ Conexion MySql ****************
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
  //La query la grabo como un string corriente
  var query = 'SELECT 1 + 1 as result';

  //******CONSULTA**********
  //Le paso la query al metodo. SIEMPRE SE HACE ASI
  con.query(query, function(err, result, fields){
    //Los resultados se ponen dentro del if
    if (err) throw err;
  });

}, 5000);
