<?php

namespace App\Http\Controllers;

use App\RetirementNeedsRecord;

use Illuminate\Http\Request;

use App\Http\Requests\RetirementNeedsRequest;

use Auth;
use Redirect;

class RetirementNeedsController extends Controller
{
    function index()
    {
        $user = Auth::user();

        $data = [
            'retirementNeeds' => RetirementNeedsRecord::where('user_id', $user->id)->first()
        ];

        if(!$data['retirementNeeds']) {
            $data['retirementNeeds'] = new RetirementNeedsRecord();
        }

        return view('retirement-needs', $data);
    }

    //
    // function saveRecord(FinancialRatioRequest $request)
    // {
    //   $record = FinancialRatioRecord::findOrNew($request->input('id'));
    //
    //   if($record->user_id && $record->user_id != Auth::user()->id) {
    //     abort(403, 'Unauthorized action.');
    //   }
    //
    //   $record->user_id = Auth::user()->id;
    //
    //   $record->financial_ratio_type_id = $request->get('financial_ratio_type_id');
    //   $record->liability = $request->get('liability');
    //   $record->asset = $request->get('asset');
    //   $record->ratio = $request->get('ratio');
    //
    //   $record->save();
    //
    //   return Redirect::back();
    // }
}
