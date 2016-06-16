<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyBudgetRecordValue extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }

    function record()
    {
        return $this->belongsTo('App\MonthlyBudgetRecord');
    }
}
