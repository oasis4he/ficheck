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


    <div class="row ">
        <div class="form-group col-xs-3 text-left">
            <span class="section-header">Total {{$monthlyBudgetCategories[$category]['title']}}</span>
        </div>

        <div class="form-group col-xs-3  valueTypeTotal planned active">
            <input readonly name="total_{{$category}}_planned" id="total_{{$category}}_planned" value="" class="form-control totalInput" aria-label="{{$monthlyBudgetCategories[$category]['title']}} Planned Total">
        </div>

        <div class="form-group col-xs-3 valueTypeTotal actual active">
            <input readonly name="total_{{$category}}_actual" id="total_{{$category}}_actual" value="" class="form-control totalInput" aria-label="{{$monthlyBudgetCategories[$category]['title']}} Actual Total">
        </div>

        <div class="form-group col-xs-3 valueTypeTotal difference active">
            <input readonly name="total_{{$category}}_difference" id="total_{{$category}}_difference" value="" class="form-control totalInput" aria-label="{{$monthlyBudgetCategories[$category]['title']}} Difference Total">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')


</div><!-- .body -->
