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
            <label for="total_{{$category}}_planned">Total {{$monthlyBudgetCategories[$category]['title']}}</label>
        </div>

        <div class="form-group col-xs-3  valueTypeTotal planned active">
            <input readonly name="total_{{$category}}_planned" id="total_{{$category}}_planned" value="" class="form-control totalInput">
        </div>

        <div class="form-group col-xs-3 valueTypeTotal actual active">
            <input readonly name="total_{{$category}}_actual" id="total_{{$category}}_actual" value="" class="form-control totalInput">
        </div>

        <div class="form-group col-xs-3 valueTypeTotal difference active">
            <input readonly name="total_{{$category}}_difference" id="total_{{$category}}_difference" value="" class="form-control totalInput">
        </div>
    </div>

    <div class="row valueTypeTotal actual {{isset($onlyActual) ? 'active' : ''}}">
        <div class="form-group col-xs-6 text-left">
            <label for="total_{{$category}}_actual">Total {{$monthlyBudgetCategories[$category]['title']}}</label>
        </div>


    </div>

    <div class="row valueTypeTotal difference">
        <div class="form-group col-xs-6 text-left">
            <label for="total_{{$category}}_difference">Total {{$monthlyBudgetCategories[$category]['title']}}</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_{{$category}}_difference" id="total_{{$category}}_difference" value="" class="form-control totalInput">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')


</div><!-- .body -->
