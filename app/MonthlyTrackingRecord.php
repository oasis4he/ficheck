<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyTrackingRecord extends Model
{
    function user()
    {
      $this->belongsTo('User');
    }
}
