<h2>Fixed Expenses</h2>
<p>Monthly payments that are always the same amount.</p>

<div class="body">
  <div class="ficheck-section-body">

    @include('partials.monthly-budget-records')

    <div class="row template">
        <div class="form-group col-xs-6 text-left">
            <label for="new_record">Add a fixed expense</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="new_record" id="new_record" value="" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-xs-6 text-left">
            <label for="total_fixed_expenses">Total Fixed Expenses</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="total_fixed_expenses" id="total_fixed_expenses" value="" class="form-control">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')

</div><!-- .body -->
