<h2>Income</h2>
<p>Money that you earn or receive each month.</p>
<div class="body income">
  <div class="ficheck-section-body">

    @include('partials.monthly-budget-records')

    @if(!isset($statement))
      <div class="row newItem">
          <div class="form-group col-xs-6 text-left">
              <label for="new_income">Add income source.</label>
          </div>

          <div class="form-group col-xs-6">
              <input name="new_income" id="new_income" value="" class="form-control">
          </div>
      </div>
    @endif

    <div class="row valueTypeTotal planned active">
        <div class="form-group col-xs-6 text-left">
            <label for="total_income_planned">Total Income</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_income_planned" id="total_income_planned" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal actual">
        <div class="form-group col-xs-6 text-left">
            <label for="total_income_actual">Total Income</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_income_actual" id="total_income_actual" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal difference">
        <div class="form-group col-xs-6 text-left">
            <label for="total_income_difference">Total Income</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_income_difference" id="total_income_difference" value="" class="form-control totalInput">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')


</div><!-- .body -->
