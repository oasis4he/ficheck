<?php

namespace App\Http\Controllers;

use App\MonthlyBudgetRecord;
use Illuminate\Http\Request;
use Auth;

class MonthlyBudgetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $monthlyBudgetRecords = MonthlyBudgetRecord::where('user_id', $user->id)->with('values')->get();

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupDefaultRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where('user_id', $user->id)->with('values')->orderBy('order')->get();
        }

        return view('monthly-budget', ['monthlyBudgetRecords' => $monthlyBudgetRecords, 'title' => 'Monthly Budget']);
    }

    public function ieStatement()
    {
        $user = Auth::user();
        $monthlyBudgetRecords = MonthlyBudgetRecord::where('user_id', $user->id)->with(['values'=>function($query){
            $query->where('type', 'actual');
        }])->get();

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupDefaultRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where('user_id', $user->id)->with('values')->orderBy('order')->get();
        }

        return view('monthly-budget', ['monthlyBudgetRecords' => $monthlyBudgetRecords, 'statement' => true, 'title' => 'I & E Statement']);
    }

    public function netWorthStatement()
    {
        $user = Auth::user();
        $monthlyBudgetRecords = MonthlyBudgetRecord::where('user_id', $user->id)->with(['values'=>function($query){
            $query->where('type', 'actual');
        }])->get();

        if(!$monthlyBudgetRecords->count()) {
            MonthlyBudgetRecord::setupDefaultRecords($user->id);

            $monthlyBudgetRecords = MonthlyBudgetRecord::where('user_id', $user->id)->with('values')->orderBy('order')->get();
        }

        return view('monthly-budget', ['monthlyBudgetRecords' => $monthlyBudgetRecords, 'statement' => true, 'title' => 'Net Worth Statement']);
    }

    public function saveRecord(Request $request)
    {
    }
}
