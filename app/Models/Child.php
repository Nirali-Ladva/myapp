<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'first_name','last_name','email','country','birth_date','age','state','city','birth_certificate'
    ];

    public function parents()
    {
        return $this->belongsToMany(ParentModel::class, 'child_parent', 'child_id', 'parent_id');
    }
}
