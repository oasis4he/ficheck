<?php

namespace App\Http\Controllers;

use App\MonthlyTrackingRecords;
use App\Http\Requests\MonthlyTrackingRequest;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Redirect;

class MonthlyTrackingController extends Controller
{
    function index()
    {
      $data = [
        'monthlyTrackingRecords' => MonthlyTrackingRecords::where('user_id', Auth::user()->id)->get()
      ];

      return view('monthly-tracking', $data);
    }

    function saveRecord(MonthlyTrackingRequest $request)
    {
      $record = MonthlyTrackingRecords::findOrNew($request->input('id'));

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->user_id = Auth::user()->id;

      $record->occurred_at = $request->get('date');

      $record->value = 0;

      if($request->has('in')) {
        $record->value += $request->get('in');
      }

      if($request->has('out')) {
        $record->value += -1 * $request->get('out');
      }

      if($request->has('category')) {
        $record->category = $request->get('category');
      }

      $record->save();

      return Redirect::back();
    }

    function deleteRecord($id)
    {
      $record = MonthlyTrackingRecords::findOrFail($id);

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->delete();

      return Redirect::back();
    }
}
