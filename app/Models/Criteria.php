<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'name'];
    protected $dates = ['deleted_at'];

    public function comparisons() {
        return $this->hasMany(CriteriaComparison::class, 'first_criteria_id')->orderBy('second_criteria_id', 'asc');
    }

    public function comparisonsX() {
        return $this->hasMany(CriteriaComparison::class, 'first_criteria_id')->orderBy('second_criteria_id', 'asc');
    }

    public function comparisonsY() {
        return $this->hasMany(CriteriaComparison::class, 'second_criteria_id');
    }

    public function priority() {
        return $this->hasOne(CriteriaPriority::class);
    }

    public function alternativeComparisons() {
        return $this->hasMany(AlternativeComparison::class);
    }

    public function alternativePriorities() {
        return $this->hasMany(AlternativePriority::class);
    }
}
