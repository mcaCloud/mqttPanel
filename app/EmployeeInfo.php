<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeInfo extends Model
{
    //Lo primero es indicar a que tabla o entidad hace referencia el modelo
    protected $table = 'employees_info';

    //RELACION MANY TO ONE
    // Me saca el objeto del usuario . EL objeto completo del usuario que ha creado informacion de empleado
    public function employee(){
    	//En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
    	//Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
		return $this -> belongsTo('App\User','user_id');   
    }
}