
<div class="row">
  <div class="col-xs-6">
    <label for="desired_years_until_retirement">Choose the number closest to number of years until you plan to retire.</label>
    <select name="desired_years_until_retirement" id="desired_years_until_retirement" class="form-control">
      <option></option>

      @foreach(['05'=>1.28,'10'=>1.63,'15'=>2.08,'20'=>2.85, '25'=>3.39, '30'=>4.32, 40=>7.04] as $age=>$factor)
        <option @if($retirementNeeds->desired_years_until_retirement==$age) selected @endif data-factor="{{$factor}}">{{$age}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-xs-6">
    <label for="retirement_years_factor">Retirement Years Index</label>
    <input name="retirement_years_factor" id="retirement_years_factor" type="number" value="{{$retirementNeeds->retirement_years_factor}}" class="form-control" readonly>
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
      &lt;-- help text --&gt;
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <br><br>
  <div class="form-group col-xs-12">
    <label for="future_value_of_savings_and_investments">Future Value of Savings/Investments</label>
    <br>
    <input name="future_value_of_savings_and_investments" id="future_value_of_savings_and_investments"  type="number" value="{{$retirementNeeds->future_value_of_savings_and_investments}}" class="form-control" readonly>
  </div>
</div>
