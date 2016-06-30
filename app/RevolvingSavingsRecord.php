<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevolvingSavingsRecord extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }
}
