<?php

namespace App\Http\Controllers;

use App\FinancialGoalType;

use Illuminate\Http\Request;

use App\Http\Requests;

class FinancialGoalsController extends Controller
{
    function index()
    {
      $data = [
        'goalTypes' => FinancialGoalType::with('goals')->orderBy('order')->get()
      ];

      return view('financial-goals', $data);
    }
}
