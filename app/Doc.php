<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
  //Lo primero es indicar a que tabla o entidad hace referencia el modelo
    protected $table = 'docs';

    //Ahora defino la relacion con las diferentes entidades

    //RELACION ONE TO MANY
    //En decir que dentro de un doc pueden hacer muchos comentarios. Cuando consigamos un objeto de tipo DOC tengamos una propiedad que contenga todos los comentarios relacionados con ese doc.

    public function comments(){
   		// Esto me crea la propiedad COMMENTS y me saca toda la informacion que este relacionada con el doc. Es decir nos carga destro de una propiedad comments todos los datos asociados al doc. Nos evita tener que escribir un monton de codigo para sacar informacion de doc. Es un camonio mucho mas facil que nos ofrece ELOQUENT y LARAVEL
        //Le hago un ORDERBY para que los comentarios me aparezcan del más nuevo al mas antiguo
    	return $this -> hasMany('App\DocComment')->orderBy('id','desc');
    }
    //RELACION MANY TO ONE
    // Me saca el objeto del usuario . EL objeto completo del usuario que ha creado el video
    public function user(){
    	//En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
    	//Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
		return $this -> belongsTo('App\User','user_id');   
    }
}
