<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LifeInsuranceRecord extends Model
{
  function user()
  {
      return $this->belongsTo('App\User');
  }
}
