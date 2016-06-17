<h2>Variable Expenses</h2>
<p class="sub-title">Monthly payments that are for different amounts.</p>

<div class="body">
  <div class="ficheck-section-body">

    @include('partials.monthly-budget-records')

    <div class="row template">
        <div class="form-group col-xs-6 text-left">
            <label for="new_record">Add a variable expense</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="new_record" id="new_record" value="" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-xs-6 text-left">
            <label for="total_variable_expenses">Total Variable Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="total_variable_expenses" id="total_variable_expenses" value="" class="form-control">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')

</div><!-- .body -->
