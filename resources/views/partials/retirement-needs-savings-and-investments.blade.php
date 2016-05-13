<div class="row">
  <div class="form-group col-xs-12">
    <label for="current_value_employee_retirement_savings">What is the current value of your employee savings plan for retirement?</label>
    <input name="current_value_employee_retirement_savings" id="current_value_employee_retirement_savings" value="{{$retirementNeeds->current_value_employee_retirement_savings}}" class="form-control">
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
    <label for="current_value_personal_retirement_savings">What is the current value of your personal savings plan for retirement?</label>
    <input name="current_value_personal_retirement_savings" id="current_value_personal_retirement_savings" value="{{$retirementNeeds->current_value_personal_retirement_savings}}" class="form-control">
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
    <label for="current_value_investments">What is the current value of your investments?</label>
    <input name="current_value_investments" id="current_value_investments" value="{{$retirementNeeds->current_value_investments}}" class="form-control">
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
    <label for="current_value_savings_and_investments">Current Value of Savings/Investments</label>
    <input name="current_value_savings_and_investments" id="current_value_savings_and_investments" value="{{$retirementNeeds->current_value_savings_and_investments}}" class="form-control" readonly>
  </div>
</div>
