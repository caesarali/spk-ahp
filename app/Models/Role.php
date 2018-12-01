<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'display_name'];
    protected $dates = ['deleted_at'];

    public function setNameAttribute($value) {
        $this->attributes['name'] = strtolower($value);
    }
}
