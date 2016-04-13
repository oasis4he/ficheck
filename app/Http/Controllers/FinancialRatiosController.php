<?php

namespace App\Http\Controllers;

use App\FinancialRatioRecord;
use App\FinancialRatioType;

use Illuminate\Http\Request;

use App\Http\Requests;

class FinancialRatiosController extends Controller
{
    function index()
    {
      $data = [
        'ratioTypes' => FinancialRatioType::with('records')->orderBy('order')->get()
      ];

      return view('financial-ratios', $data);
    }
}
