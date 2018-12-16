<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternativePriority extends Model
{
    protected $fillable = ['criteria_id', 'alternative_id', 'value'];
}
