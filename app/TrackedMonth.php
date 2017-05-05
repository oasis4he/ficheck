<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackedMonth extends Model
{
    function records() {
      return $this->hasMany('App\MonthlyTrackingRecord', 'month_id', 'id');
    }
}
