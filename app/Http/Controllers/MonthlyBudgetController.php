<?php

namespace App\Http\Controllers;

use App\MonthlyBudgetRecord;
use App\MonthlyBudgetRecordValue;
use App\MonthlyTrackingRecord;
use Illuminate\Http\Request;
use Auth;
use Redirect;

class MonthlyBudgetController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->viewUser;
        $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->get();

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupMonthlyRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->orderBy('order')->get();
        }

        $trackedCategories = MonthlyTrackingRecord::whereIn('category', $monthlyBudgetRecords->pluck('description'));

        return view('monthly-budget', ['calculator' => 'monthly-budget', 'monthlyBudgetCategories' => $this->getMonthlyBudgetCategories(), 'monthlyBudgetRecords' => $monthlyBudgetRecords, 'title' => 'Monthly Budget']);
    }

    public function ieStatement(Request $request)
    {
        $user = $request->viewUser;
        $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->get();


        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupMonthlyRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where(['user_id' => $user->id, 'calculator' => 'monthly-budget'])->with('values')->orderBy('order')->get();
        }

        return view('monthly-budget', ['calculator' => 'monthly-budget', "onlyActual" => true,
                    'monthlyBudgetCategories' => $this->getMonthlyBudgetCategories(),
                    'monthlyBudgetRecords' => $monthlyBudgetRecords, 'statement' => true,
                    "showTotals" => true, 'title' => 'I & E Statement']);
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

        return view('monthly-budget', ['calculator' => 'net-worth', 'monthlyBudgetRecords' => $monthlyBudgetRecords, "monthlyBudgetCategories" => $monthlyBudgetCategories,
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
                  $record->description = $value['name'];
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
}
