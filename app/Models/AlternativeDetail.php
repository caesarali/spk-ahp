<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class AlternativeDetail extends Model
{
    // use SoftDeletes;

    protected $fillable = ['alternative_id', 'criteria_id', 'value'];

    public function alternative() {
        return $this->belongsTo(Alternative::class);
    }

    public function criteria() {
        return $this->belongsTo(Criteria::class);
    }
}
