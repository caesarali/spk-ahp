<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CriteriaComparison extends Model
{
    protected $fillable = ['first_criteria_id', 'value', 'second_criteria_id'];

    protected $appends = ['normalization_value'];

    public function getNormalizationValueAttribute() {
        return $this->attributes['normalization_value'] = $this->normalization->value ?? 0;
    }

    public function firstCriteria() {
        return $this->belongsTo(Criteria::class, 'first_criteria_id')->withTrashed();
    }

    public function secondCriteria() {
        return $this->belongsTo(Criteria::class, 'second_criteria_id')->withTrashed();
    }

    public function normalization() {
        return $this->hasOne(CriteriaNormalization::class, 'comparison_id');
    }
}
