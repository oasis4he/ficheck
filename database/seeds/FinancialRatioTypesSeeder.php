<?php

use Illuminate\Database\Seeder;

use App\FinancialRatioType;

class FinancialRatioTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratioTypes = [
            [
                'title' => 'Basic Liquidity Ratio',
                'slug' => 'basic-liquidity',
                'asset_label' => 'Liquid Assets',
                'asset_description' => '<-- help text -->',
                'asset_link' => '/net-worth-statement',
                'asset_link_text' => 'view Net Worth Statement',
                'liability_label' => 'Monthly Expenses',
                'liability_description' => '<-- help text -->',
                'liability_link' => '/income-and-expense-statement',
                'liability_link_text' => 'view I & E Statement',
                'ratio_label' => 'Basic Liquidity Ratio',
                'ratio_description' => '<p>The basic liquidity ratio reveals the number
of months you could meet your current
expenses using liquid assets without
additional income.</p>
<strong>Recommendation: 3.0 or more</strong>',
                'order' => '1',
            ],
            [
                'title' => 'Debt-to-Asset Ratio',
                'slug' => 'debt-to-asset',
                'asset_label' => 'Total Assets',
                'asset_description' => '<-- help text -->',
                'asset_link' => '/net-worth-statement',
                'asset_link_text' => 'view Net Worth Statement',
                'liability_label' => 'Total Liabilities',
                'liability_description' => '<-- help text -->',
                'liability_link' => '/net-worth-statement',
                'liability_link_text' => 'view Net Worth Statement',
                'ratio_label' => 'Debt-to-Asset Ratio',
                'ratio_description' => '<p>The debt-to-asset ratio measures solvency.
If a you owe more than you own, you are
insolvent. You would not be able to pay all
your debts if you sold your assets.</p>
<strong>Recommendation: The further below 1.0
the better. Over 1.0 is insolvent.</strong>',
                'order' => '2',
            ],
            [
                'title' => 'Debt Payment-to-Income Ratio',
                'slug' => 'debt-payment-to-income',
                'liability_label' => 'Annual Debt Payments',
                'liability_description' => '<-- help text -->',

                'asset_link'=>null,
                'asset_link_text'=>null,
                'liability_link'=>null,
                'liability_link_text'=>null,

                'asset_label' => 'Gross Income',
                'asset_description' => '<-- help text -->',

                'ratio_label' => 'Debt P-to-I Ratio',
                'ratio_description' => '<p>TThe debt payment-to-income ratio shows
your ability to make current debt payments.</p>
<strong>Recommendation: <ul><li>below .36 is adequate</li><li>.37 to .41 is marginal</li><li>above .41 is risky</li></ul></strong>',
                'order' => '3',
            ],
        ];


        foreach($ratioTypes as $i=>$ratioType) {
            $newRatioType = new FinancialRatioType();

            $newRatioType->title = $ratioType['title'];
            $newRatioType->slug = $ratioType['slug'];
            $newRatioType->order = $ratioType['order'];

            $newRatioType->asset_label = $ratioType['asset_label'];
            $newRatioType->asset_description = $ratioType['asset_description'];
            $newRatioType->asset_link = $ratioType['asset_link'];
            $newRatioType->asset_link_text = $ratioType['asset_link_text'];
            $newRatioType->liability_label = $ratioType['liability_label'];
            $newRatioType->liability_description = $ratioType['liability_description'];
            $newRatioType->liability_link = $ratioType['liability_link'];
            $newRatioType->liability_link_text = $ratioType['liability_link_text'];
            $newRatioType->ratio_label = $ratioType['ratio_label'];
            $newRatioType->ratio_description = $ratioType['ratio_description'];

            try {
                $newRatioType->save();
            } catch (Exception $e) {
                // pass
            }
        }
    }
}
