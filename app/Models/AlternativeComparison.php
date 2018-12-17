<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternativeComparison extends Model
{
    protected $fillable = ['criteria_id', 'x_alternative_id', 'y_alternative_id', 'value'];

    protected $appends = ['normalization_value'];

    public function getNormalizationValueAttribute() {
        return $this->attributes['normalization_value'] = $this->normalization->value ?? 0;
    }

    public function criteria() {
        return $this->belongsTo(Criteria::class)->withTrashed();
    }

    public function alternativeX() {
        return $this->belongsTo(Alternative::class, 'x_alternative_id')->withTrashed();
    }

    public function alternativeY() {
        return $this->belongsTo(Alternative::class, 'y_alternative_id')->withTrashed();
    }

    public function normalization() {
        return $this->hasOne(AlternativeNormalization::class, 'comparison_id');
    }
}
