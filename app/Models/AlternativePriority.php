<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternativePriority extends Model
{
    protected $fillable = ['criteria_id', 'alternative_id', 'value'];

    public function criteria() {
        return $this->belongsTo(Criteria::class);
    }

    public function alternative() {
        return $this->belongsTo(Alternative::class);
    }
}
