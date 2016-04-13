<?php

use Illuminate\Database\Seeder;

use App\FinancialGoalType;

class FinancialGoalTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goalTypes = [
            [
                'title' => 'Short-Term Goal',
                'description' => '0-12 months',
                'slug' => 'short-term'
            ],
            [
                'title' => 'Intermediate Goal',
                'description' => '1-5 years',
                'slug' => 'intermediate-term'
            ],
            [
                'title' => 'Long-Term Goal',
                'description' => '5+ years',
                'slug' => 'long-term'
            ]
        ];


        foreach($goalTypes as $i=>$goalType) {
            $newGoalType = new FinancialGoalType();

            $newGoalType->title = $goalType['title'];
            $newGoalType->description = $goalType['description'];
            $newGoalType->slug = $goalType['slug'];
            $newGoalType->order = $i;

            $newGoalType->save();
        }
    }
}
