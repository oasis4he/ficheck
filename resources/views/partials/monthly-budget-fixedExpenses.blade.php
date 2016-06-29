<h2>Fixed Expenses</h2>
<p>Monthly payments that are always the same amount.</p>

<div class="body fixedExpenses">
  <div class="ficheck-section-body">

    @include('partials.monthly-budget-records')

    <div class="row newItem">
        <div class="form-group col-xs-6 text-left">
            <label for="new_fixed_expense">Add a fixed expense</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="new_fixed_expense" id="new_fixed_expense" value="" class="form-control" readonly>
        </div>
    </div>

    <div class="row valueTypeTotal planned active">
        <div class="form-group col-xs-6 text-left">
            <label for="total_fixed_expenses_planned">Total Fixed Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="total_fixed_expenses_planned" id="total_fixed_expenses_planned" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal actual">
        <div class="form-group col-xs-6 text-left">
            <label for="total_fixed_expenses_actual">Total Fixed Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="total_fixed_expenses_actual" id="total_fixed_expenses_actual" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal difference">
        <div class="form-group col-xs-6 text-left">
            <label for="total_fixed_expenses_difference">Total Fixed Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="total_fixed_expenses_difference" id="total_fixed_expenses_difference" value="" class="form-control totalInput">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')

</div><!-- .body -->
