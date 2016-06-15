<?php

namespace App\Http\Controllers;

use App\LifeInsuranceRecord;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;


class LifeInsuranceController extends Controller
{
  function index()
  {
      $user = Auth::user();

      $data = [
          'lifeInsurance' => LifeInsuranceRecord::where('user_id', $user->id)->first()
      ];

      if(!$data['lifeInsurance']) {
          $data['lifeInsurance'] = new LifeInsuranceRecord();
      }

      return view('life-insurance', $data);
  }
}
