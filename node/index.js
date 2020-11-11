//Lo primero que hago es llamar las librerias de MySql y mqtt
//Creo una variable para que me guarde la peticion de requerir esas librerias
var mysql = require('mysql');
//Para MQTT vamos a utilizar la libreria que me recomienda EMQX, aunque tambien podriamos utilizar -Paho mqtt-
var mqtt = require('mqtt');
