<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
//use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
//use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Illuminate\Database\Eloquent\Model;

/*Este es un TRAIT con metodos que se usan regularmente*/
/*Este trait permite filtrar los folders por usuario*/
/*Lo tuve que crear manualmente*/
use App\Traits\FilterByUser;

class File extends Model
{
    
    use SoftDeletes, FilterByUser;


   //Lo primero es indicar a que tabla o entidad hace referencia el modelo
    protected $table = 'files';
    // Estas con las propiedades de la tabla que se van a poder asignar en arrays y consultas a la tabla
    protected $fillable = ['uuid', 'folder_id', 'created_by_id','file_path'];
       

    public function setFolderIdAttribute($input)
    {
        $this->attributes['folder_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }
    

    //Ahora defino la relacion con las diferentes entidades

//***********RELACION MANY TO ONE********************//

    //Me saca el objeto del Folder. El objeto completo del folder donde se creo el archivo.
    public function folder()
    {
        //En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
        //Es decir que dentro del metodo FOLDER va a cargar todo el objeto del folder que se identifique con el folder_id.
        return $this->belongsTo(Folder::class, 'folder_id')->withTrashed();
    }

    //RELACION ONE TO MANY
    //En decir que dentro de un file pueden hacer muchos comentarios. Cuando consigamos un objeto de tipo FILE tengamos una propiedad que contenga todos los comentarios relacionados con ese file.

    public function comments(){
        // Esto me crea la propiedad COMMENTS y me saca toda la informacion que este relacionada con el file. Es decir nos carga destro de una propiedad coments todos los datos asociados al File. Nos evita tener que escribir un monton de codigo para sacar informacion de video. Es un camino mucho mas facil que nos ofrece ELOQUENT y LARAVEL
        //Le hago un ORDERBY para que los comentarios me aparescan del mas nuevo al mas antiguo
        return $this -> hasMany('App\FileComment')->orderBy('id','desc');
    }


    // Me saca el objeto del usuario . EL objeto completo del usuario que ha creado el file
    public function created_by()
    {
        //En este caso necesito definir en que campo se va a relacionar, que fue lo que hicimos al crear las Foreing keys en la table.
        //Es decir que dentro de la propiedad USER va a cargar todo el objeto del usuario que se identifique con el user_id.
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function toggleAccess($type)
  {
      $this->attributes[$type] = ($this->attributes[$type]) ? false : true;
  }
 
}