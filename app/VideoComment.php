<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoComment extends Model
{
    protected $table = 'video__comments';
 //RELACION MANY TO ONE
    // Me saca el objeto del usuario . EL objeto completo del ususario que ha creado el comentario
    public function user(){
    	//En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
    	//Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
		return $this -> belongsTo('App\User','user_id');   
    }
   //RELACION MANY TO ONE
   //Arriba tengo una relacion de muchos a uno con entidad de usuarios pero tambien necesito un relacion con los videos, para que podamos sacar el video que tengamos adjunto a ese comentario

   public function video(){
   		return $this -> belongsTo('App\Video','video_id');
   		//De esta manera cuando saca mi comentario en el controlador pueda acceder a una propiedad video.  
   }  
}
