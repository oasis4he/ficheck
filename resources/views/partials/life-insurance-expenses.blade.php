<div class="row">
  <div class="form-group col-xs-12">
    <label for="funeral_expenses">Funeral expenses.</label>
    <input name="funeral_expenses" id="funeral_expenses" type="number" value="{{$lifeInsurance->funeral_expenses}}" class="form-control">
  </div>
</div>

<div class="row">
  <div class="form-group col-xs-12">
    <label for="debt">Debt.</label>
    <input name="debt" id="debt" type="number" value="{{$lifeInsurance->debt}}" class="form-control">
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
      Debt is the money you owe for credit cards, home and auto loans, and other money that you have borrowed. If you have already completed the Net Worth Statement, use the Total Liabilities amount here.
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <div class="form-group col-xs-12">
    <label for="other_expenses">Other expenses.</label>
    <input name="other_expenses" id="other_expenses" type="number" value="{{$lifeInsurance->other_expenses}}" class="form-control">
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
      Other expenses may include day care, college, readjustment period for spouse, etc.
    </div>
  </div>
</div><!-- .row:has(:input) -->

<div class="row">
  <div class="form-group col-xs-12">
    <label for="entered_total_income_replacement">Total for Income Replacement</label>
    <input readonly name="entered_total_income_replacement" id="entered_total_income_replacement" type="number" value="{{$lifeInsurance->entered_total_income_replacement}}" class="form-control">
  </div>
</div>

<div class="row">
  <br><br>
  <div class="form-group col-xs-12">
    <label for="total_expenses">Total Expenses</label>
    <br>
    <input name="total_expenses" id="total_expenses" type="number" value="{{$lifeInsurance->total_expenses}}" class="form-control" readonly>
  </div>
</div>
