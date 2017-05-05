<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyTrackingRecord extends Model
{
    function trackedMonth()
    {
        return $this->belongsTo('App\TrackedMonth', 'month_id');
    }
}
