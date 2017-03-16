<?php

namespace App\Http\Controllers;

use App\MonthlyTrackingRecord;
use App\TrackedMonth;
use App\Http\Requests\MonthlyTrackingRequest;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Redirect;

use Carbon\Carbon;

class MonthlyTrackingController extends Controller
{
    function index(Request $request)
    {
      $user = $request->viewUser;
      $userTrackedMonths = TrackedMonth::where('user_id', $user->id)->get();
      $monthIDs = $userTrackedMonths->pluck('id');

      $currentMonth = new Carbon('first day of this month');

      if($userTrackedMonths->isEmpty()){

        $trackedMonth = new TrackedMonth;
        $trackedMonth->user_id = $user->id;
        $trackedMonth->month = $currentMonth->format('n');
        $trackedMonth->year = $currentMonth->format('Y');
        $trackedMonth->save();
        $monthIDs = array($trackedMonth->id);
      }

      $userTrackedMonths = TrackedMonth::where('user_id', $user->id)->get();

      $data = [
        'monthlyTrackingRecords' =>  MonthlyTrackingRecord::whereIn('month_id', $monthIDs)->orderBy('month_id')->orderBy('occurred_at')->get(),
        'trackedMonths' => $userTrackedMonths,
        'months' => [
          '12' => 'December',
          '11' => 'November',
          '10' => 'October',
          '9' => 'September',
          '8' => 'August',
          '7' => 'July',
          '6' => 'June',
          '5' => 'May',
          '4' => 'April',
          '3' => 'March',
          '2' => 'February',
          '1' => 'January'
        ],
        'years' => array_reverse(range('2012', '2017')),
        'currentMonth' => $currentMonth->format('n'),
        'currentYear' => $currentMonth->format('Y'),
      ];

      return view('monthly-tracking', $data);
    }

    function saveRecord(MonthlyTrackingRequest $request)
    {
      $record = MonthlyTrackingRecord::findOrNew($request->input('id'));
      $date = new Carbon($request->get('date'));

      if($request->has('month_id')) {
        $trackedMonth = TrackedMonth::where('id', $request->get('month_id'))->first();
      } else {
        $trackedMonth = TrackedMonth::where('user_id', Auth::user()->id)->where('month', $date->format('n'))->where('year', $date->format('Y'))->first();
      }

      if(!$trackedMonth) {
        $trackedMonth = new TrackedMonth;
        $trackedMonth->user_id = Auth::user()->id;
        $trackedMonth->month = $date->format('n');
        $trackedMonth->year = $date->format('Y');
        $trackedMonth->save();
      }
      // if($record->user_id && $record->user_id != Auth::user()->id) {
      //   abort(403, 'Unauthorized action.');
      // }


      $record->month_id = $trackedMonth->id;

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
      $record = MonthlyTrackingRecord::findOrFail($id);

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->delete();

      return Redirect::back();
    }
}
