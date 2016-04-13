<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialGoalType extends Model
{
    function goals()
    {
        return $this->hasMany('App\FinancialGoal');
    }
}
