<div class="row">
  <div class="form-group col-xs-12">
    <label for="annual_income">How much do your dependents need for annual income if you were gone?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="annual_income" id="annual_income" type="number" value="{{$lifeInsurance->annual_income}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <div class="help-controls">
      <a href="#show-help">show help</a>
      <a href="#hide-help" class="hide">hide help</a>
    </div>

  </div>
  <div class="description">
    <div class="description-content">
      This is the amount of money that is left after taxes.
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <div class="col-xs-6">
    <label for="years_income_replacement_needed">Choose the number of years income replacement will be needed.</label>
    <select name="years_income_replacement_needed" id="years_income_replacement_needed" class="form-control">
      <option></option>

      @foreach(['10'=>8.98,'15'=>12.84,'20'=>16.35,'25'=>19.52,'30'=>22.39, '40'=>31.42] as $age=>$factor)
        <option @if($lifeInsurance->years_income_replacement_needed==$age) selected @endif data-factor="{{$factor}}">{{$age}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-xs-6">
    <label for="income_replacement_factor">Income Replacement Index</label>
    <input name="income_replacement_factor" id="income_replacement_factor"  type="number" value="{{$lifeInsurance->income_replacement_factor}}" class="form-control" readonly>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <div class="help-controls">
      <a href="#show-help">show help</a>
      <a href="#hide-help" class="hide">hide help</a>
    </div>

  </div>
  <div class="description">
    <div class="description-content">
      Select the number from the list that is closest to matching the number of years you think you will live after you retire. A factor based on the number of years you select will be displayed. This is used to calculate your Total for Income Replacement.
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <br><br>
  <div class="form-group col-xs-12">
    <label for="total_income_replacement">Total for Income Replacement</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="total_income_replacement" id="total_income_replacement" type="number" value="{{$lifeInsurance->total_income_replacement}}" step="1" class="form-control" readonly>
    </div>
  </div>
</div>
