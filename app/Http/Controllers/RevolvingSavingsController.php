<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\RevolvingSavingsRecord;

use Illuminate\Http\Request;

use Auth;
use Redirect;

class RevolvingSavingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $revolvingSavingsRecord = RevolvingSavingsRecord::where(['user_id' => $user->id])->get()->groupBy("month")->toArray();
        // dd($revolvingSavingsRecord);

        return view('revolving-savings', ['months' => $this->getMonths(), 'revolvingSavingsRecord' => $revolvingSavingsRecord, 'title' => 'Revolving Savings']);
    }

    public function getMonths()
    {
        return [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
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
                    $record = new RevolvingSavingsRecord;
                    $record->user_id = Auth::user()->id;
                    $record->month = $explodedKey[1];
                }
                else
                {//save an existing record
                    $record = RevolvingSavingsRecord::find($key);
                }

                if (isset($value['name']))
                {
                    $record->description = $value['name'];
                }

                $record->value = $value['value'];
                $record->save();

            }
          }//if isset($request['names'])

          if (isset($request['deletedIds']))
          {
              //remove records from the database that have been deleted
              foreach ($request['deletedIds'] as $index => $id) {
                  RevolvingSavingsRecord::destroy($id);
              }
          }

          return Redirect::back();
    }
}
