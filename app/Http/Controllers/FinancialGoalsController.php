<?php

namespace App\Http\Controllers;

use App\FinancialGoal;
use App\FinancialGoalType;
use App\Http\Requests\FinancialGoalRequest;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Redirect;

class FinancialGoalsController extends Controller
{
    function index()
    {
        $user = Auth::user();
        $data = [
            'goalTypes' => FinancialGoalType::with(['goals'=>function($query) use ($user) {
                $query->where('user_id', $user->id)->orderBy('date');
            }])->orderBy('order')->get()
        ];

        return view('financial-goals', $data);
    }

    function saveRecord(FinancialGoalRequest $request)
    {
      $record = FinancialGoal::findOrNew($request->input('id'));

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->user_id = Auth::user()->id;

      $record->date = $request->get('date');
      $record->financial_goal_type_id = $request->get('financial_goal_type_id');
      $record->description = $request->get('description');
      $record->plan = $request->get('plan');
      $record->cost = $request->get('cost');

      $record->save();

      return Redirect::back();
    }

    function deleteRecord($id)
    {
      $record = FinancialGoal::findOrFail($id);

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->delete();

      return Redirect::back();
    }
}
