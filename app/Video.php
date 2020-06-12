<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
   //Lo primero es indicar a que tabla o entidad hace referencia el modelo

    protected $table = 'videos';

    //Ahora defino la relacion con las diferentes entidades

    //RELACION ONE TO MANY
    //En decir que dentro de un video pueden hacer muchos comentarios. Cuando consigamos un objeto de tipo VIDEO tengamos una propiedad que contenga todos los comentarios relacionados con ese video.

    public function comments(){
   		// Esto me crea la propiedad COMMENTS y me saca toda la informacion que este relacionada con el video. Es decir nos carga dentro de una propiedad comments todos los datos asociados al Video. Nos evita tener que escribir un monton de codigo para sacar informacion de video. Es un camonio mucho mas facil que nos ofrece ELOQUENT y LARAVEL
        //Le hago un ORDERBY para que los comentarios me aparescan del mas nuevo al mas antiguo
    	return $this -> hasMany('App\VideoComment')->orderBy('id','desc');
    }
    //RELACION MANY TO ONE
    // Me saca el objeto del usuario . EL objeto completo del usuario que ha creado el video
    public function user(){
    	//En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
    	//Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
		return $this -> belongsTo('App\User','user_id');   
    }
}
