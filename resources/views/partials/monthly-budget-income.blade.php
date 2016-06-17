<h2>Income</h2>
<p>Money that you earn or receive each month.</p>
<div class="body">
  <div class="ficheck-section-body">

    @include('partials.monthly-budget-records')

    <div class="row template">
        <div class="form-group col-xs-6 text-left">
            <label for="new_record">Add income source.</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="new_record" id="new_record" value="" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-xs-6 text-left">
            <label for="total_income">Total Income</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="total_income" id="total_income" value="" class="form-control">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')


</div><!-- .body -->
