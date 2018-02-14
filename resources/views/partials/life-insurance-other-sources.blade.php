<div class="row">
  <div class="form-group col-xs-12">
    <label for="government_benefits">Government benefits.</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="government_benefits" id="government_benefits" type="number" value="{{$lifeInsurance->government_benefits}}" class="form-control">
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
      Take the monthly amount of Social Security survivor benefits, multiply by 12 months, and then multiply by the number of years the benefit will be received (Example: $1237 X 12 months X 14 years = $207,816).
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <div class="form-group col-xs-12">
    <label for="other_funds">Other funds.</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="other_funds" id="other_funds" type="number" value="{{$lifeInsurance->other_funds}}" class="form-control">
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
      Other funds include current assets, income from family members, etc. If you have already completed the Net Worth Statement, your current assets are the Total Assets amount
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <br><br>
  <div class="form-group col-xs-12">
    <label for="total_funds_from_other_sources">Total Funds from other Sources</label>
    <div class="input-group">
      <span class="input-group-addon">$</span>
      <input name="total_funds_from_other_sources" id="total_funds_from_other_sources"  type="number" value="{{$lifeInsurance->total_funds_from_other_sources}}" class="form-control" readonly>
    </div>
  </div>
</div>
