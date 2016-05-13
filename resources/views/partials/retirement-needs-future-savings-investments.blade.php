<div class="row">
  <div class="form-group col-xs-12">
    <label for="desired_retirement_age">Choose the number closest to number of years until you plan to retire.</label>
  </div>
</div>

<div class="row">
  <div class="col-xs-6">
    <select name="retirment_years_age" id="retirment_years_age" class="form-control">
      <option></option>

      @foreach(['05'=>1.28,'10'=>1.63,'15'=>2.08,'20'=>2.85, '25'=>3.39, '30'=>4.32, 40=>7.04] as $age=>$factor)
        <option @if($retirementNeeds->retirment_years_age==$age) value="{{$retirementNeeds->retirment_years_age}}" @endif data-factor="{{$factor}}">{{$age}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-xs-6">
    <input name="retirment_years_factor" id="retirment_years_factor" value="{{$retirementNeeds->retirment_years_factor}}" class="form-control" readonly>
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
    <input name="future_value_of_savings_and_investments" id="future_value_of_savings_and_investments" value="{{$retirementNeeds->future_value_of_savings_and_investments}}" class="form-control" readonly>
  </div>
</div>
