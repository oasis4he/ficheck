<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
  protected $table = 'semesters';
  public function users()
  {
      return $this->belongsToMany('App\Users', 'user_semesters')->withTimestamps();
  }
}