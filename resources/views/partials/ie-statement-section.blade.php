<h2>{{$monthlyBudgetCategories[$category]['title']}}</h2>
<p>{{$monthlyBudgetCategories[$category]['definition']}}</p>
<div class="body {{$category}}">
  <div class="ficheck-section-body">

    @include('partials.ie-statement-records')

    @if(!isset($statement))
      <div class="row newItem">
          <div class="form-group col-xs-6 text-left">
              <label for="new_{{$category}}">Add {{$monthlyBudgetCategories[$category]['secondaryText']}} source.</label>
           </div>

          <div class="form-group col-xs-6">
              <input name="{{$category}}" id="{{$category}}" value="" class="form-control">
          </div>
       </div>
     @endif

    <div class="row valueTypeTotal actual {{isset($onlyActual) ? 'active' : ''}}">
        <div class="form-group col-xs-6 text-left">
            <label for="total_{{$category}}_actual">Total {{$monthlyBudgetCategories[$category]['title']}}</label>
        </div>

        <div class="form-group col-xs-6">
            <input readonly name="total_{{$category}}_actual" id="total_{{$category}}_actual" value="" class="form-control totalInput">
        </div>
    </div>

  </div><!-- .ficheck-section-body -->

  @include('partials.monthly-show-hide-controls')


</div><!-- .body -->
