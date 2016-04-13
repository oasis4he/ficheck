<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }

    function goals()
    {
        return $this->belongsTo('App\FinancialGoalType');
    }
}
