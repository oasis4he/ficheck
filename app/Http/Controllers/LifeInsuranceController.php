<?php

namespace App\Http\Controllers;

use App\LifeInsuranceRecord;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Redirect;


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


  function saveRecord(Request $request)
  {

    $record = LifeInsuranceRecord::findOrNew($request->input('id'));

    if($record->user_id && $record->user_id != Auth::user()->id) {
      abort(403, 'Unauthorized action.');
    }

    $record->user_id = Auth::user()->id;

    $record->annual_income = $request->get('annual_income');
    $record->insurance_needs = $request->get('insurance_needs');
    $record->years_income_replacement_needed = $request->get('years_income_replacement_needed');
    $record->income_replacement_factor = $request->get('income_replacement_factor');
    $record->total_income_replacement = $request->get('total_income_replacement');
    $record->funeral_expenses = $request->get('funeral_expenses');
    $record->debt = $request->get('debt');
    $record->other_expenses = $request->get('other_expenses');
    $record->entered_total_income_replacement = $request->get('entered_total_income_replacement');
    $record->total_expenses = $request->get('total_expenses');
    $record->government_benefits = $request->get('government_benefits');
    $record->other_funds = $request->get('other_funds');
    $record->total_funds_from_other_sources = $request->get('total_funds_from_other_sources');
    $record->entered_total_expenses = $request->get('entered_total_expenses');
    $record->entered_total_funds_from_other_sources = $request->get('entered_total_funds_from_other_sources');
    $record->insurance_needed = $request->get('insurance_needed');


    $record->save();

    return Redirect::back();
  }
}
