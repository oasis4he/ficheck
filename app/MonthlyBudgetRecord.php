<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyBudgetRecord extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function values()
    {
        return $this->hasMany('App\MonthlyBudgetRecordValue', 'record_id', 'id');
    }

    static public function setupDefaultRecords($user_id)
    {
        $recordValueTypes = [
            "planned",
            "actual",
            "difference"
        ];

        $categories = [
            'income' => [
                'Salary (take home)',
                'Bonuses, tips, etc.',
                'Interest & Dividends',
            ],

            'fixedExpenses' => [
                'Rent or Mortgage',
                'Revolving Savings',
                'Loan #1 Fixed Expenses',
                'Insurance',
            ],

            'variableExpenses' => [
                'Utilities',
                'Phone',
                'Internet',
                'Food - Groceries',
                'Eating Out',
                'Gasoline',
                'Household',
                'Pet Care',
                'Clothing',
                'Laundry',
                'Medical - Doctors',
                'Medical - Prescriptions',
                'Personal Allowance',
                'Entertainment',
                'Contributions',
            ],
        ];

        $count=0;

        foreach ($categories as $category => $records) {

            foreach ($records as $description) {
                $count++;

                $newRecord = new MonthlyBudgetRecord();

                $newRecord->category = $category;

                $type = 'expense';
                if($category == 'income') {
                    $type = 'income';
                }

                $newRecord->type = $type;
                $newRecord->user_id = $user_id;
                $newRecord->description = $description;
                $newRecord->order = $count;

                $newRecord->save();

                //Loop through record values and set default to 0
                foreach ($recordValueTypes as $type) {
                    $newValue = new MonthlyBudgetRecordValue();
                    $newValue->record_id = $newRecord->id;
                    $newValue->type = $type;
                    $newValue->value = 0;
                    $newValue->save();
                }
            }
        }
    }
}
