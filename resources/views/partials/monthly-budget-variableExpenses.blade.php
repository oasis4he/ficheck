<h2>Variable Expenses</h2>
<p class="sub-title">Monthly payments that are for different amounts.</p>

<div class="body variableExpenses">
  <div class="ficheck-section-body">

    @include('partials.monthly-budget-records')

    @if(!isset($statement))
      <div class="row newItem">
          <div class="form-group col-xs-6 text-left">
              <label for="new_variable_expense">Add a variable expense</label>
          </div>

          <div class="form-group col-xs-6">
              <input name="new_variable_expense[]" id="new_variable_expense" value="" class="form-control">
          </div>
      </div>
    @endif

    <div class="row valueTypeTotal planned active">
        <div class="form-group col-xs-6 text-left">
            <label for="total_variable_expenses_planned">Total Variable Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_variable_expenses_planned" id="total_variable_expenses_planned" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal actual">
        <div class="form-group col-xs-6 text-left">
            <label for="total_variable_expenses_actual">Total Variable Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_variable_expenses_actual" id="total_variable_expenses_actual" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal difference">
        <div class="form-group col-xs-6 text-left">
            <label for="total_variable_expenses_difference">Total Variable Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_variable_expenses_difference" id="total_variable_expenses_difference" value="" class="form-control totalInput">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')

</div><!-- .body -->
