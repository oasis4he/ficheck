<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }

    function type()
    {
        return $this->belongsTo('App\FinancialGoalType', 'financial_goal_type_id');
    }
}
