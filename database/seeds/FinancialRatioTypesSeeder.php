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
                'asset_description' => '<p><em>Liquid assets</em> are items that you can sell in a short amount of time, with little or no loss in value. Your <em>liquid assets</em> amount is the total of the money you would receive.</p>',
                'asset_link' => '/net-worth-statement',
                'asset_link_text' => 'view Net Worth Statement',
                'liability_label' => 'Monthly Expenses',
                'liability_description' => '<p>Your <em>monthly expenses</em> amount is the total of all the money that you spend each month. You can base this number on your completed <strong>Monthly Tracking</strong> form.</p>',
                'liability_link' => '/income-and-expense-statement',
                'liability_link_text' => 'view I & E Statement',
                'ratio_label' => 'Basic Liquidity Ratio',
                'ratio_description' => '<p>Your <em>basic liquidity ratio</em> is the number of months that you could pay your monthly expenses using only your liquid assets.</p><strong>Recommendation: 3.0 or more</strong>',
                'order' => '1',
            ],
            [
                'title' => 'Asset to Debt Ratio',
                'slug' => 'asset-to-debt',
                'asset_label' => 'Total Assets',
                'asset_description' => '<p>Your <em>total assets</em> amount is a single figure that represents the cash value of everything you own.  If you have completed the <strong>Net Worth Statement</strong>, use the <strong>Total Assets</strong> amount here.</p>',
                'asset_link' => '/net-worth-statement',
                'asset_link_text' => 'view Net Worth Statement',
                'liability_label' => 'Total Liabilities',
                'liability_description' => '<p>Your <em>total liabilities</em> amount is a single figure that represents the total of all debt balances that you are responsible for paying back.   If you have completed the <strong>Net Worth Statement</strong>, use the <strong>Total Liabilities</strong> amount here.</p>',
                'liability_link' => '/net-worth-statement',
                'liability_link_text' => 'view Net Worth Statement',
                'ratio_label' => 'Asset-to-Debt Ratio',
                'ratio_description' => '<p>If your asset-to-debt ratio is <strong>above 1.0</strong>, you could pay all of your liabilities by selling all of your assets--your are <em>solvent</em>.</p>
<p>If your <em>asset-to-debt ratio</em> is <strong>below 1.0</strong> you would not be able to pay all of your liabilities by selling all of your assets--your are <em>insolvent</em>.</p>',
                'order' => '2',
            ],
            [
                'title' => 'Debt Payment-to-Income Ratio',
                'slug' => 'debt-payment-to-income',
                'liability_label' => 'Annual Debt Payments',
                'liability_description' => '<p>Your <em>annual debt payments</em> amount is a single figure that represents all of the money that you are responsible for paying toward debt in one year.</p>',

                'asset_link'=>null,
                'asset_link_text'=>null,
                'liability_link'=>null,
                'liability_link_text'=>null,

                'asset_label' => 'Gross Income',
                'asset_description' => '<p>Your <em>gross income</em> amount is a single figure that represents all of the money that you receive in one year, before you have paid any taxes.</p>',

                'ratio_label' => 'Debt P-to-I Ratio',
                'ratio_description' => '<p>Your <em>debt payment-to-income ratio</em> shows your ability to make your debt payments on time.</p>
                <ul><li><strong>Below .36:</strong> You will probably be able to make all your debt payments.</li><li><strong>.36 to .41:</strong> You may not be able to make all of your debt payments.</li><li><strong>.41 and up:</strong> You will probably not be able to make all your debt payments.</li></ul>',
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
