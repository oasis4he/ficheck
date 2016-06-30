<div class="budget-sums">
  <div class="row budget-sum budget-sum-income">
    <div class="col-xs-7">
      <label for="incomeTotal">
        Total {{$calculator == 'monthly-budget' ? 'Income' : 'Assets'}}
      </label>
    </div>

    <div class="col-xs-5">
      <input class="form-control" type="text" readonly id="incomeTotal">
    </div>
  </div>

  <div class="row budget-sum budget-sum-expenses">
    <div class="col-xs-7">
      <label for="expenseTotal">
        Total {{$calculator == 'monthly-budget' ? 'Expenses' : 'Liabilities'}}
      </label>
    </div>

    <div class="col-xs-5">
      <input class="form-control" type="text" readonly id="expenseTotal">
    </div>
  </div>

  <div class="row budget-sum budget-sum-net">
    <div class="col-xs-7">
      <label for="netTotal">
        Net {{$calculator == 'monthly-budget' ? 'Gain/Loss' : 'Worth'}}
      </label>
    </div>

    <div class="col-xs-5">
      <input class="form-control" type="text" readonly id="netTotal">
    </div>
  </div>
</div>
