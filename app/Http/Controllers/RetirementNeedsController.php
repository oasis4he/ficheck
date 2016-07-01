<?php

namespace App\Http\Controllers;

use App\RetirementNeedsRecord;

use Illuminate\Http\Request;

use App\Http\Requests\RetirementNeedsRequest;

use Auth;
use Redirect;

class RetirementNeedsController extends Controller
{
    function index(Request $request)
    {
        $user = $request->viewUser;

        $data = [
            'retirementNeeds' => RetirementNeedsRecord::where('user_id', $user->id)->first()
        ];

        if(!$data['retirementNeeds']) {
            $data['retirementNeeds'] = new RetirementNeedsRecord();
        }

        return view('retirement-needs', $data);
    }

    function saveRecord(Request $request)
    {

      $record = RetirementNeedsRecord::findOrNew($request->input('id'));

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->user_id = Auth::user()->id;

      $record->annual_income = $request->get('annual_income');
      $record->annual_ss_benefit = $request->get('annual_ss_benefit');
      $record->annual_employer_benefit = $request->get('annual_employer_benefit');
      $record->additional_annual_income_required = $request->get('additional_annual_income_required');
      $record->desired_retirement_age = $request->get('desired_retirement_age');
      $record->retirement_age_factor = $request->get('retirement_age_factor');
      $record->retirement_goal = $request->get('retirement_goal');
      $record->employee_retirement_savings = $request->get('employee_retirement_savings');
      $record->personal_retirement_savings = $request->get('personal_retirement_savings');
      $record->investements_value = $request->get('investements_value');
      $record->retirement_savings_and_investments = $request->get('retirement_savings_and_investments');
      $record->desired_years_until_retirement = $request->get('desired_years_until_retirement');
      $record->retirement_years_factor = $request->get('retirement_years_factor');
      $record->future_value_of_savings_and_investments = $request->get('future_value_of_savings_and_investments');
      $record->entered_retirement_goal = $request->get('entered_retirement_goal');
      $record->entered_future_value_of_savings_and_investments = $request->get('entered_future_value_of_savings_and_investments');
      $record->additional_savings_needed_for_retirement = $request->get('additional_savings_needed_for_retirement');
      $record->entered_desired_retirement_age = $request->get('entered_desired_retirement_age');
      $record->entered_retirement_age_factor = $request->get('entered_retirement_age_factor');
      $record->addition_annual_savings_required = $request->get('addition_annual_savings_required');

      $record->save();

      return Redirect::back();
    }
}
