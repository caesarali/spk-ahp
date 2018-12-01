<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alternative extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'name'];
    protected $dates = ['deleted_at'];

    public function details() {
        return $this->hasMany(AlternativeDetail::class, 'alternative_id');
    }
}
