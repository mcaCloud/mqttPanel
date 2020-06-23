<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class Alert extends Model
{
  //Lo primero es indicar a que tabla o entidad hace referencia el modelo
  protected $table = 'alerts';

  protected $fillable = [
    'title',
    'description',
    'created_at',
    'updated_At',
    'image',

  ];

  //RELACION MANY TO ONE
    // Me saca el objeto del usuario . EL objeto completo del usuario que ha creado la Alerta
    public function user(){
    	//En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
    	//Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
		return $this -> belongsTo('App\User','user_id');   
    }


    public function toggleAccess($type)
  {
      $this->attributes[$type] = ($this->attributes[$type]) ? false : true;
  }

   	public function toggleAccess1($type)
  {
      $this->attributes[$type] = ($this->attributes[$type]) ? false : true;
  }
}
