<div class="row">
  <div class="form-group col-xs-12">
    <label for="entered_total_expenses">Enter your Total Expenses.</label>
    <input readonly name="entered_total_expenses" id="entered_total_expenses"  type="number" value="{{$lifeInsurance->entered_total_expenses}}" class="form-control">
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
    <label for="entered_total_funds_from_other_sources">Enter your Total Funds from other Sources.</label>
    <input readonly name="entered_total_funds_from_other_sources" id="entered_total_funds_from_other_sources"  type="number" value="{{$lifeInsurance->entered_total_funds_from_other_sources}}" class="form-control">
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
    <label for="insurance_needed">Insurance Needed</label>
    <br>
    <input name="insurance_needed" id="insurance_needed" type="number" value="{{$lifeInsurance->insurance_needed}}" class="form-control" readonly>
  </div>
</div>
