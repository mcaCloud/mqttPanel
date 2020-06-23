<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //Lo primero es indicar a que tabla o entidad hace referencia el modelo

    protected $table = 'offices';

    protected $fillable = [
      'name',
      'description',
      'street_name',
      'street_number',
      'floor',
      'floor_door',
      'floor_letter',
      'zip_code',
      'manual_directions',
      'metro_station_1',
      'metro_line_1',
      'metro_station_2',
      'metro_line_2',
      'bus_line',
      'bus_line_letter',
      'renfe_line',
      'renfe_line_letter',
      'schedule_days',
      'schedule_hours',
      'email',
      'phone_number',
      'website',
      'appt_req',
      'status',
      'updated_at'


   ];

    //Ahora defino la relacion con las diferentes entidades

    //RELACION ONE TO MANY
    //En decir que dentro de un Oficina pueden hacer muchos comentarios. Cuando consigamos un objeto de tipo OFFICE tengamos una propiedad que contenga todos los comentarios relacionados con esa OFICINA.

    public function comments(){
   		// Esto me crea la propiedad COMMENTS y me saca toda la informacion que este relacionada con la officina. Es decir nos carga dentro de una propiedad comments todos los datos asociados a la Oficina. Nos evita tener que escribir un monton de codigo para sacar informacion de la oficina. Es un caminio mucho mas facil que nos ofrece ELOQUENT y LARAVEL
        //Le hago un ORDERBY para que los comentarios me aparescan del mas nuevo al mas antiguo
    	return $this -> hasMany('App\OfficeComment')->orderBy('id','desc');
    }
    //RELACION MANY TO ONE
    // Me saca el objeto del usuario . EL objeto completo del usuario que ha creado la oficina
    public function user(){
    	//En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
    	//Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
		return $this -> belongsTo('App\User','user_id');   
    }

    public function toggleAccess($type)
  {
      $this->attributes[$type] = ($this->attributes[$type]) ? false : true;
  }
}
