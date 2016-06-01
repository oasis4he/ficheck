<div class="row">
  <div class="form-group col-xs-12">
    <label for="employee_retirement_savings">What is the current value of your employee savings plan for retirement?</label>
    <input name="employee_retirement_savings" id="employee_retirement_savings" value="{{$retirementNeeds->employee_retirement_savings}}" class="form-control">
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
    <label for="personal_retirement_savings">What is the current value of your personal savings plan for retirement?</label>
    <input name="personal_retirement_savings" id="personal_retirement_savings" value="{{$retirementNeeds->personal_retirement_savings}}" class="form-control">
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
    <label for="investements_value">What is the current value of your investments?</label>
    <input name="investements_value" id="investements_value" value="{{$retirementNeeds->investements_value}}" class="form-control">
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
    <label for="retirement_savings_and_investments">Current Value of Savings/Investments</label>
    <input name="retirement_savings_and_investments" id="retirement_savings_and_investments" value="{{$retirementNeeds->retirement_savings_and_investments}}" class="form-control" readonly>
  </div>
</div>
