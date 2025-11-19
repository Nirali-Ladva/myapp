<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    protected $table = 'parents';
    protected $fillable = [
        'first_name','last_name','email','country','birth_date','age','state','city',
        'residential_proofs','profile_image','education','occupation'
    ];

    protected $casts = [
        'residential_proofs' => 'array',
    ];

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_parent', 'parent_id', 'child_id');
    }
}
