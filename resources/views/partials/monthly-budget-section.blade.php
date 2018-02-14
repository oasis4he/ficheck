<h2>{{$monthlyBudgetCategories[$category]['title']}}</h2>
<p>{{$monthlyBudgetCategories[$category]['definition']}}</p>
<div class="body {{$category}}">
  <div class="ficheck-section-body">
    <div class="row">
      <div class="col-xs-3 col-xs-offset-3 section-header">
        Planned
      </div>
      <div class="col-xs-3 section-header">
        Actual
      </div>
      <div class="col-xs-3 section-header">
        Difference
      </div>
    </div>

    @include('partials.monthly-budget-records')

    @if(!isset($statement))
      <div class="row newItem">
          <div class="form-group col-xs-3 text-left">
             <label for="new_{{$category}}">Add {{$monthlyBudgetCategories[$category]['secondaryText']}} source.</label>
          </div>

          <div class="form-group col-xs-3">
              <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input name="{{$category}}" id="{{$category}}" value="" class="form-control">
              </div>
          </div>
          <div class="form-group col-xs-3">
              <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input name="{{$category}}" id="{{$category}}" value="" class="form-control">
              </div>
          </div>
          <div class="form-group col-xs-3">
              <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input name="{{$category}}" id="{{$category}}" value="" class="form-control" readonly>
              </div>
          </div>
      </div>
   @endif


    <div class="row ">
        <div class="form-group col-xs-3 text-left">
            <span class="section-header">Total {{$monthlyBudgetCategories[$category]['title']}}</span>
        </div>

        <div class="form-group col-xs-3  valueTypeTotal planned active">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input readonly name="total_{{$category}}_planned" id="total_{{$category}}_planned" value="" class="form-control totalInput" aria-label="{{$monthlyBudgetCategories[$category]['title']}} Planned Total">
            </div>
        </div>

        <div class="form-group col-xs-3 valueTypeTotal actual active">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input readonly name="total_{{$category}}_actual" id="total_{{$category}}_actual" value="" class="form-control totalInput" aria-label="{{$monthlyBudgetCategories[$category]['title']}} Actual Total">
            </div>
        </div>

        <div class="form-group col-xs-3 valueTypeTotal difference active">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input readonly name="total_{{$category}}_difference" id="total_{{$category}}_difference" value="" class="form-control totalInput" aria-label="{{$monthlyBudgetCategories[$category]['title']}} Difference Total">
            </div>
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')


</div><!-- .body -->
