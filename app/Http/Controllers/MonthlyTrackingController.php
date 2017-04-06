<?php

namespace App\Http\Controllers;

use App\MonthlyTrackingRecord;
use App\TrackedMonth;

use App\MonthlyBudgetRecord;
use App\MonthlyBudgetRecordValue;

use App\Http\Requests\MonthlyTrackingRequest;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Redirect;
use Session;

use Carbon\Carbon;

class MonthlyTrackingController extends Controller
{
    function index(Request $request)
    {
      $user = $request->viewUser;
      $userTrackedMonths = TrackedMonth::where('user_id', $user->id)->get();
      $monthIDs = $userTrackedMonths->pluck('id');

      $currentMonth = new Carbon('first day of this month');
      $selectedMonth = $currentMonth->format('m');
      $selectedYear = $currentMonth->format('Y');
      if($request->session()->has('selectedMonth')){
        $selectedMonth = $request->session()->get('selectedMonth');
        $selectedYear = $request->session()->get('selectedYear');
      }


      if($userTrackedMonths->isEmpty()){

        $trackedMonth = new TrackedMonth;
        $trackedMonth->user_id = $user->id;
        $trackedMonth->month = $currentMonth->format('m');
        $trackedMonth->year = $currentMonth->format('Y');
        $trackedMonth->save();
        $monthIDs = array($trackedMonth->id);
      }

      $userTrackedMonths = TrackedMonth::where('user_id', $user->id)->orderBy('year', 'desc')->orderBy('month', 'desc')->get();

      $data = [
        'monthlyTrackingRecords' =>  MonthlyTrackingRecord::whereIn('month_id', $monthIDs)->orderBy('month_id')->orderBy('occurred_at', 'desc')->get(),
        'trackedMonths' => $userTrackedMonths,
        'months' => [
          '12' => 'December',
          '11' => 'November',
          '10' => 'October',
          '09' => 'September',
          '08' => 'August',
          '07' => 'July',
          '06' => 'June',
          '05' => 'May',
          '04' => 'April',
          '03' => 'March',
          '02' => 'February',
          '01' => 'January'
        ],
        'currentMonth' => $selectedMonth,
        'currentYear' => $selectedYear,
        'saved' => $request->session()->has('saved') ? $request->session()->get('saved') : false,
        'title' => 'Monthly Tracking'
      ];

      $request->session()->forget('saved');

      return view('monthly-tracking', $data);
    }

    function saveRecord(MonthlyTrackingRequest $request)
    {
      $record = MonthlyTrackingRecord::findOrNew($request->input('id'));
      $date = new Carbon($request->get('date'));
      $oldCategory = $record->category;


      if($request->has('month_id')) {
        $trackedMonth = TrackedMonth::where('id', $request->get('month_id'))->first();
        if($trackedMonth) {
          $trackedMonthStartDate = Carbon::createFromDate($trackedMonth->year, $trackedMonth->month)->startOfMonth();
          $trackedMonthEndDate = Carbon::createFromDate($trackedMonth->year, $trackedMonth->month)->endOfMonth();
          if(!$date->between($trackedMonthStartDate, $trackedMonthEndDate)){
            // updated date falls outside of the current tracked month attached to the updated entry so it needs to be moved to the correct month
            $trackedMonth = TrackedMonth::where('user_id', Auth::user()->id)->where('month', $date->format('m'))->where('year', $date->format('Y'))->first();
          }

        }
      } else {
        $trackedMonth = TrackedMonth::where('user_id', Auth::user()->id)->where('month', $date->format('m'))->where('year', $date->format('Y'))->first();
      }

      if($request->has('in')){
        $category = MonthlyBudgetRecord::where('user_id', Auth::user()->id)->where('type','income')->where('description', $request->get('category'))->first();
      } else {
        $category = MonthlyBudgetRecord::where('user_id', Auth::user()->id)->where('type','expense')->where('description', $request->get('category'))->first();
      }

      if(!$category) {
        $this->createCategory($request->all());
      }

      if(!$trackedMonth) {
        $trackedMonth = new TrackedMonth;
        $trackedMonth->user_id = Auth::user()->id;
        $trackedMonth->month = $date->format('m');
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

      //check if there are any remaining records for the iltracked month, if not delete it.
      $monthRecords = MonthlyTrackingRecord::where('month_id', $request->get('month_id'))->get();
      if($monthRecords->isEmpty()){
        $this->deleteMonth($request->get('month_id'));
        $request->session()->forget('selectedMonth');
        $request->session()->forget('selectedYear');
        $request->session()->forget('saved');
      } else {
        $request->session()->put('selectedMonth', $trackedMonth->month);
        $request->session()->put('selectedYear', $trackedMonth->year);
        $request->session()->put('saved', $record->occurred_at);
      }


      if($oldCategory && $oldCategory != $record->category){
        $this->checkCategory(Auth::user()->id, $oldCategory);
      }

      $data = [
        'records' => $record->load('trackedMonth'),
        'months'=> [
          '12' => 'December',
          '11' => 'November',
          '10' => 'October',
          '09' => 'September',
          '08' => 'August',
          '07' => 'July',
          '06' => 'June',
          '05' => 'May',
          '04' => 'April',
          '03' => 'March',
          '02' => 'February',
          '01' => 'January'
        ]
      ];

      return json_encode($data);
    }

    function deleteRecord(Request $request, $id)
    {
      $record = MonthlyTrackingRecord::findOrFail($id);
      $trackedMonth = $record->month_id;
      $oldCategory = $record->category;

      if($record->user_id && $record->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
      }

      $record->delete();

      $this->checkCategory(Auth::user()->id, $record->category);

      //check if there are any remaining records for the tracked month, if not delete it.
      $monthRecords = MonthlyTrackingRecord::where('month_id', $trackedMonth)->get();
      if($monthRecords->isEmpty()){
        $this->deleteMonth($trackedMonth);
        $request->session()->forget('selectedMonth');
        $request->session()->forget('selectedYear');
        $request->session()->forget('saved');
      }

      return Redirect::back();
    }

    function createCategory($data)
    {
      $values = [
        'planned',
        'actual',
        'difference'
      ];

      $newCategory = new MonthlyBudgetRecord;
      $newCategory->user_id = Auth::user()->id;

      if(isset($data['in'])) {
        $newCategory->type = 'income';
        $newCategory->category = 'income';
      } else {
        $newCategory->type = 'expense';
        $newCategory->category = 'variableExpenses';
      }

      $newCategory->description = $data['category'];
      $newCategory->calculator = 'monthly-budget';

      $newCategory->save();

      foreach ($values as $value) {
        $recordValue = new MonthlyBudgetRecordValue;
        $recordValue->record_id = $newCategory->id;
        $recordValue->type = $value;
        $recordValue->value = 0;
        $recordValue->save();
      }
    }

    function deleteMonth($id)
    {
      $record = TrackedMonth::find($id);
      if($record) {
        if($record->user_id && $record->user_id != Auth::user()->id) {
          abort(403, 'Unauthorized action.');
        }

        $record->delete();
      }

      return;
    }

    function categories(Request $request, $type=null)
    {
      $user = $request->viewUser;
      if($type){
        $monthlyBudgetCategories = MonthlyBudgetRecord::where('user_id', $user->id)->where('type', $type)->get();
      } else {
        $monthlyBudgetCategories = MonthlyBudgetRecord::where('user_id', $user->id)->get();
      }
      return $monthlyBudgetCategories->pluck('description')->toJson();
    }

    function checkCategory($user, $name)
    {
      $categoryRecords = MonthlyTrackingRecord::whereHas('trackedMonth', function($query) use($user) {
                                                  $query->where('user_id', $user);
                                                })->where('category', $name)->get();
      if($categoryRecords->isEmpty()){
        //the category is no longer being used. Delete it.
        $budgetCategory = MonthlyBudgetRecord::where('user_id', $user)->where('description', $name)->first();


        if($budgetCategory){
          $categoryValues =  MonthlyBudgetRecordValue::where('record_id', $budgetCategory->id)->get();

          foreach ($categoryValues as $value) {
            $value->delete();
          }
          $budgetCategory->delete();
         }
      }
    }

}
