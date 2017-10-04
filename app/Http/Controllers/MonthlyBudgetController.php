<?php

namespace App\Http\Controllers;

use App\MonthlyBudgetRecord;
use App\MonthlyBudgetRecordValue;
use App\MonthlyTrackingRecord;
use App\TrackedMonth;

use Illuminate\Http\Request;
use Auth;
use Redirect;

use Carbon\Carbon;

class MonthlyBudgetController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->viewUser;

        $data = $this->getTrackedCategoryRecords($user, []);

        $monthlyBudgetRecords = $data['budgetRecords'];

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupMonthlyRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->orderBy('order')->get();
        }

        return view('monthly-budget', ['calculator' => 'monthly-budget', 'monthlyBudgetCategories' => $this->getMonthlyBudgetCategories(), 'monthlyBudgetRecords' => $monthlyBudgetRecords, 'title' => 'Monthly Budget', 'trackedMonthRecords' => $data['trackedMonthRecords'], 'trackedMonth' => $data['month'], 'trackedYear' => $data['year']]);
    }

    public function ieStatement(Request $request)
    {
        $user = $request->viewUser;
        $params['month'] = $request->get('month');
        $params['year'] = $request->get('year');
        $data = $this->getTrackedCategoryRecords($user, $params, true);

        $monthlyBudgetRecords = $data['budgetRecords'];

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupMonthlyRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->orderBy('order')->get();
        }

        $userTrackedMonths = TrackedMonth::where('user_id', $user->id)->orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        return view('ie-statement', ['calculator' => 'monthly-budget', "onlyActual" => true,
                    'monthlyBudgetCategories' => $this->getMonthlyBudgetCategories(),
                    'monthlyBudgetRecords' => $monthlyBudgetRecords,
                    'trackedRecords' => $data['trackedRecords'], 'statement' => true,
                    "showTotals" => true, 'title' => 'I & E Statement', 'trackedMonthRecords' => $data['trackedRecords'],
                    'trackedMonth' => $data['month'], 'trackedYear' => $data['year'],
                    'trackedMonths' => $userTrackedMonths,
                    'months' => $data['months']]
                  );

    }

    public function netWorthStatement(Request $request)
    {
        $user = $request->viewUser;
        $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'net-worth'])->with(['values'=>function($query){
            $query->where('type', 'actual');
        }])->get();

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupNetWorthRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'net-worth'])->with(['values'=>function($query){
                $query->where('type', 'actual');
            }])->orderBy('order')->get();
        }

        //set up monthly budget categories
        $monthlyBudgetCategories = [
          "liquidAssets" => [
            "title" => "Liquid Assets",
            "definition" => "Definition Here",
            "secondaryText" => "Liquid Asset",
          ],
          "tangibleAssets" => [
            "title" => "Tangible Assets",
            "definition" => "Definition Here",
            "secondaryText" => "Tangible Asset",
          ],
          "investments" => [
            "title" => "Investments",
            "definition" => "Definition Here",
            "secondaryText" => "Investment",
          ],
          "shortTermLiability" => [
            "title" => "Short Term Liability",
            "definition" => "Definition Here",
            "secondaryText" => "Short Term Liability",
          ],
          "longTermLiability" => [
            "title" => "Long Term Liability",
            "definition" => "Definition Here",
            "secondaryText" => "Long Term Liability",
          ],
        ];

        return view('ie-statement', ['calculator' => 'net-worth', 'monthlyBudgetRecords' => $monthlyBudgetRecords, 'trackedMonthRecords' => true, 'trackedMonth' => false, "monthlyBudgetCategories" => $monthlyBudgetCategories,
                    "showTotals" => true, "onlyActual" => true, 'title' => 'Net Worth Statement']);
    }

    public function getMonthlyBudgetCategories()
    {
      //set up monthly budget categories
      return [
        "income" => [
          "title" => "Income",
          "definition" => "Money that you earn or receive each month.",
          "secondaryText" => "income",
        ],
        "variableExpenses" => [
          "title" => "Variable Expenses",
          "definition" => "Monthly payments that are for different amounts.",
          "secondaryText" => "variable expense",
        ],
        "fixedExpenses" => [
          "title" => "Fixed Expenses",
          "definition" => "Monthly payments that are always the same amount.",
          "secondaryText" => "fixed expense",
        ],
      ];
    }

    public function saveRecord(Request $request)
    {
      // dd($request->all());

      if (isset($request['names']))
      {
          //loop through changed records and update/insert
          foreach($request['names'] as $key => $value)
          {
              $explodedKey = explode("_", $key);

              if (count($explodedKey) > 1)
              {//this is a new_id
                  $record = new MonthlyBudgetRecord;
                  $record->user_id = Auth::user()->id;
                  $record->category = $explodedKey[1];
                  $record->calculator = $request['calculator'];
                  $record->type = $explodedKey[2];
                  $record->description = isset($value['name']) ? $value['name'] : 'Budget Item';
                  $record->save();

                  unset($value['name']);

                  //loop through values and save
                  foreach ($value as $valueKey => $rValue) {
                      $valueKey = explode("_", $valueKey);

                      $recordValue = new MonthlyBudgetRecordValue;
                      $recordValue->record_id = $record->id;
                      $recordValue->type = $valueKey[0];
                      $recordValue->value = $rValue['values'];

                      $recordValue->save();
                  }
              }
              else
              {//save an existing record
                  $record = MonthlyBudgetRecord::find($key);
                  $record->description = $value['name'];
                  $record->save();
              }

          }
        }//if isset($request['names'])

        //save any value for records that already existed
        foreach ($request['values'] as $type => $values) {
            foreach ($values as $id => $value) {
                $recordValue = MonthlyBudgetRecordValue::find($id);
                $recordValue->value = $value;
                $recordValue->save();
            }
        }

        if (isset($request['deletedIds']))
        {
            //remove records from the database that have been deleted
            foreach ($request['deletedIds'] as $index => $id) {
                $recordValues = MonthlyBudgetRecordValue::select()->where("record_id", "=", $id);
                $recordValues->delete();
                MonthlyBudgetRecord::destroy($id);
            }
        }

        return Redirect::back();

    }

    function getTrackedCategoryRecords($user, $data, $statement=false){
      $trackedMonthRecords = false;
      $trackedRecords = false;

      if(isset($data['month']) && isset($data['year'])) {
        $trackedMonth = TrackedMonth::where('user_id', $user->id)->where('month', $data['month'])->where('year', $data['year'])->with('records')->first();
      } else {
        $trackedMonth = TrackedMonth::where('user_id', $user->id)->orderBy('year', 'desc')->orderBy('month', 'desc')->with('records')->first();
      }

      $months = [
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
      ];

      $trackedCategories = $trackedMonth->records->pluck('category')->toArray();
        if($statement){
          if($trackedCategories) {
            $trackedMonthRecords = true;
            $records = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->whereIn('description', $trackedCategories)->with(['values' => function($query){
                $query->where('type', 'actual');
              }])->orderBy('type', 'desc')->orderBy('category', 'asc')->get();
          } else {
            $records = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with(['values' => function($query){
                $query->where('type', 'actual');
              }])->orderBy('type', 'desc')->orderBy('category', 'asc')->get();
          }
          $trackedRecords = MonthlyTrackingRecord::where('month_id', $trackedMonth->id)->groupBy('category')->selectRaw('sum(value) as sum, category, id')->orderBy('category', 'desc')->get();
        } else {
          if($trackedCategories) {
            $trackedMonthRecords = true;
            $monthlyRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->whereIn('description', $trackedCategories)->orderBy('type', 'desc')->orderBy('category', 'asc')->get();
            $addedRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->whereHas('values', function($query){
                $query->where('value', '!=', 0);
            })->orderBy('type', 'desc')->orderBy('category', 'asc')->get();
            $records = $monthlyRecords->merge($addedRecords);
          } else {
            $records = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->orderBy('type', 'desc')->orderBy('category', 'asc')->get();
          }

          $trackedRecords = MonthlyTrackingRecord::where('month_id', $trackedMonth->id)->get();
        }

      return ['trackedMonthRecords' => $trackedMonthRecords, 'budgetRecords' => $records, 'trackedRecords' => !$trackedRecords->isEmpty() ? $trackedRecords : false, 'month' => $months[$trackedMonth->month], 'year' => $trackedMonth->year, 'months' => $months];
    }
}
