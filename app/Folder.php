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
    protected $fillable = ['name', 'created_by_id'];

    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }
    
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
