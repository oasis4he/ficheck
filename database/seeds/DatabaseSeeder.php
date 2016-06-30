<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(FinancialGoalTypesSeeder::class);
        $this->call(FinancialRatioTypesSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
