<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialRatioType extends Model
{
    function records()
    {
        return $this->hasMany('App\FinancialRatioRecord');
    }
}
