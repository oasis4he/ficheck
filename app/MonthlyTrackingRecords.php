<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyTrackingRecords extends Model
{
    function user()
    {
      $this->belongsTo('User');
    }
}
