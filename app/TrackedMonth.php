<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackedMonth extends Model
{
  /**
   * Get the records for the tracked month.
   */
  public function records()
  {
      return $this->hasMany('App\MonthlyTrackingRecord');
  }
}
