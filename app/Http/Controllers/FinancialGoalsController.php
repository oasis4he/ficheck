<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FinancialGoalsController extends Controller
{
    function index()
    {
      return view('financial-goals');
    }
}
