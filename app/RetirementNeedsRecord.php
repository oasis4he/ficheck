<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetirementNeedsRecord extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }
}
