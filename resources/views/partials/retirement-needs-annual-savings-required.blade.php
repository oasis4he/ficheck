<div class="row">
  <div class="form-group col-xs-12">
    <label for="entered_retirement_goal">Enter your Retirement Goal.</label>
    <input name="entered_retirement_goal" id="entered_retirement_goal" value="{{$retirementNeeds->entered_retirement_goal}}" class="form-control">
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
  <div class="form-group col-xs-12">
    <label for="entered_future_value_of_savings_and_investments">Enter your Savings/Investments Future Value</label>
    <input name="entered_future_value_of_savings_and_investments" id="entered_future_value_of_savings_and_investments" value="{{$retirementNeeds->entered_future_value_of_savings_and_investments}}" class="form-control">
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
  <div class="form-group col-xs-12">
    <label for="additional_savings_needed_for_retirement">This is the additional savings that you will need for retirement.</label>
    <input name="additional_savings_needed_for_retirement" id="additional_savings_needed_for_retirement" value="{{$retirementNeeds->additional_savings_needed_for_retirement}}" class="form-control" readonly>
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
  <div class="form-group col-xs-12">
    <label for="entered_desired_retirement_age">Choose the number closest to number of years until you plan to retire.</label>
  </div>
</div>

<div class="row">
  <div class="col-xs-6">
    <select name="entered_desired_retirement_age" id="entered_desired_retirement_age" class="form-control">
      <option></option>

      @foreach(['05'=>5.53,'10'=>12.58,'15'=>21.58,'20'=>33.07, '25'=>44.73, '30'=>66.44, 40=>120.8] as $age=>$factor)
        <option @if($retirementNeeds->entered_desired_retirement_age==$age) selected @endif data-factor="{{$factor}}">{{$age}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-xs-6">
    <input name="entered_retirement_age_factor" id="entered_retirement_age_factor" value="{{$retirementNeeds->entered_retirement_age_factor}}" class="form-control" readonly>
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
    <label for="addition_annual_savings_required">Annual Savings needed to reach your Retirement Goal.</label>
    <br>
    <input name="addition_annual_savings_required" id="addition_annual_savings_required" value="{{$retirementNeeds->addition_annual_savings_required}}" class="form-control" readonly>
  </div>
</div>
