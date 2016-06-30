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

    static public function setupNetWorthRecords($user_id)
    {
        $recordValueTypes = [
            "actual",
        ];

        $categories = [
            'liquidAssets' => [
                'Cash',
                'Checking',
                'Saving',
                'Cert. of Deposit',
                'Money Market Funds',
            ],

            'tangibleAssets' => [
                'Home',
                'Auto 1',
                'Auto 2',
                'Personal Property',
            ],

            'investments' => [
                'Stocks',
                'Bonds',
                'Mutual Funds',
                'Retirement Funds',
            ],

            'shortTermLiability' => [
                'Credit Card 1',
                'Credit Card 2',
                'Credit Card 3',
                'Credit Card 4',
            ],

            'longTermLiability' => [
                'Home',
                'Auto 1',
                'Auto 2',
                'Student Loan',
            ],
        ];

        MonthlyBudgetRecord::setupDefaultRecords('net-worth', $recordValueTypes, $categories, $user_id);
      }

    static public function setupMonthlyRecords($user_id)
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

        MonthlyBudgetRecord::setupDefaultRecords('monthly-budget', $recordValueTypes, $categories, $user_id);
      }

      private static function setupDefaultRecords($calculator, $recordValueTypes, $categories, $user_id)
      {
        $count=0;

        foreach ($categories as $category => $records) {

            foreach ($records as $description) {
                $count++;

                $newRecord = new MonthlyBudgetRecord();

                $newRecord->category = $category;

                $type = 'expense';
                if($category == 'income' || $category == 'liquidAssets' || $category == 'tangibleAssets' || $category == 'investments') {
                    $type = 'income';
                }

                $newRecord->calculator = $calculator;
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
