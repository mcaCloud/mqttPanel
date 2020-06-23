<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/*Este es un TRAIT con metodos que se usan regularmente*/
/*Este trait permite filtrar los folders por usuario*/
/*Lo tuve que crear manualmente*/
use App\Traits\FilterByUser;

class Cathegory extends Model
{
    use SoftDeletes, FilterByUser;

      //Lo primero es indicar a que tabla o entidad hace referencia el modelo
    protected $table = 'cathegory';

    protected $fillable = [
    	'name', 
    	'description',
    	'created_by_id'
    ];

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
