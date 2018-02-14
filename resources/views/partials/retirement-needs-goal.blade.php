<div class="row">
  <div class="form-group col-xs-12">
    <label for="annual_income">What annual income will you need for retirement?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="annual_income" id="annual_income"  type="number" value="{{$retirementNeeds->annual_income}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="annual_ss_benefit">What annual benefit will Social Security provide?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="annual_ss_benefit" id="annual_ss_benefit" type="number" value="{{$retirementNeeds->annual_ss_benefit}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="annual_employer_benefit">What annual benefit will your employer provide?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="annual_employer_benefit" id="annual_employer_benefit" type="number" value="{{$retirementNeeds->annual_employer_benefit}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="additional_annual_income_required">The additional annual income you will need:</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="additional_annual_income_required" id="additional_annual_income_required" type="number" value="{{$retirementNeeds->additional_annual_income_required}}" class="form-control" readonly>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-6">
    <label for="desired_retirement_age">Choose the number closest to the age you plan to retire.</label>
    <select name="desired_retirement_age" id="desired_retirement_age" class="form-control">
      <option></option>

      @foreach(['55'=>21,'60'=>18.9,'65'=>16.4,'70'=>13.6] as $age=>$factor)
        <option @if($retirementNeeds->desired_retirement_age==$age) selected @endif data-factor="{{$factor}}">{{$age}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-xs-6">
    <label for="retirement_age_factor">Retirement Goal Age Index</label>
    <input name="retirement_age_factor" id="retirement_age_factor"  type="number" value="{{$retirementNeeds->retirement_age_factor}}" class="form-control" readonly>
  </div>
</div>

<div class="row">
  <br><br>
  <div class="form-group col-xs-12">
    <label for="retirement_goal">Retirement Goal</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="retirement_goal" id="retirement_goal"  type="number" value="{{$retirementNeeds->retirement_goal}}" class="form-control" readonly>
    </div>
  </div>
</div>
