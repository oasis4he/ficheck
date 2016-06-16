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

        return view('monthly-budget', ['monthlyBudgetRecords' => $monthlyBudgetRecords]);
    }

    public function saveRecord(Request $request)
    {
    }
}
