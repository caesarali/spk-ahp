<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CriteriaComparison extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_criteria_id', 'value', 'second_criteria_id'];
    protected $dates = ['deleted_at'];

    public function firstCriteria() {
        return $this->belongsTo(Criteria::class, 'first_criteria_id')->withTrashed();
    }

    public function secondCriteria() {
        return $this->belongsTo(Criteria::class, 'second_criteria_id')->withTrashed();
    }
}
