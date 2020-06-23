<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/*Este es un TRAIT con metodos que se usan regularmente*/
/*Este trait permite filtrar los folders por usuario*/
/*Lo tuve que crear manualmente*/
use App\Traits\FilterByUser;

class Folder extends Model
{

    use SoftDeletes, FilterByUser;

          //Lo primero es indicar a que tabla o entidad hace referencia el modelo
    protected $table = 'folders';

    protected $fillable = ['name', 'created_by_id'];

    //Esto lo que hace es dejarme guardar un JSON o un array en este campo. Lo necesito porque tengo que guardar varias oficinas que trabajan estos folders (Servicios) 

    //Si no estoy usando el tema de arrays tengo no debo tener esto activado porque sino me da errors
    /*protected $casts = [
        'office_id' => 'array',
    ];*/

    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }
    
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

        public function toggleAccess($type)
  {
      $this->attributes[$type] = ($this->attributes[$type]) ? false : true;
  }
}
