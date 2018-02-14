<div class="row">
  <div class="form-group col-xs-12">
    <label for="employee_retirement_savings">What is the current value of your employee savings plan for retirement?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="employee_retirement_savings" id="employee_retirement_savings" type="number" value="{{$retirementNeeds->employee_retirement_savings}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="personal_retirement_savings">What is the current value of your personal savings plan for retirement?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="personal_retirement_savings" id="personal_retirement_savings"  type="number" value="{{$retirementNeeds->personal_retirement_savings}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="investements_value">What is the current value of your investments?</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="investements_value" id="investements_value"  type="number" value="{{$retirementNeeds->investements_value}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="retirement_savings_and_investments">Current Value of Savings/Investments</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="retirement_savings_and_investments" id="retirement_savings_and_investments"  type="number" value="{{$retirementNeeds->retirement_savings_and_investments}}" class="form-control" readonly>
    </div>
  </div>
</div>
