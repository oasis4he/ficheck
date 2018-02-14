<div class="row">
  <div class="form-group col-xs-12">
    <label for="entered_total_expenses">Total Expenses</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input readonly name="entered_total_expenses" id="entered_total_expenses"  type="number" value="{{$lifeInsurance->entered_total_expenses}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="entered_total_funds_from_other_sources">Total Funds from other Sources</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input readonly name="entered_total_funds_from_other_sources" id="entered_total_funds_from_other_sources"  type="number" value="{{$lifeInsurance->entered_total_funds_from_other_sources}}" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <br><br>
  <div class="form-group col-xs-12">
    <label for="insurance_needed">Insurance Needed</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="insurance_needed" id="insurance_needed" type="number" value="{{$lifeInsurance->insurance_needed}}" class="form-control" readonly>
    </div>
  </div>
</div>
