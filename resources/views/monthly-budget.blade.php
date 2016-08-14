@extends('layouts.app')

@section('content')
  <form method="post" action="/monthly-budget" class="budget-view {{isset($statement) ? 'readonly' : ''}} {{isset($onlyActual) ? 'onlyActual' : ''}}">
    {{ csrf_field() }}
    <input type="hidden" name="calculator" value="{{$calculator}}">
    <div class="ficheck-sections budget-view-record">
      @include('layouts.title', ['title'=>$title])

      @include('partials.form-errors')

      @if(isset($showTotals))
        @include('partials.monthly-budget-totals')
      @else
      <div class="row toggleBudgetSection" data-spy="affix" data-offset-top="70">
        <div class="pull-right">
          <button type="button" class="toggleBudgetInputs planned active">P</button>
          <button type="button" class="toggleBudgetInputs actual">A</button>
          <button type="button" class="toggleBudgetInputs difference">+/-</button>
        </div>
      </div>

      @endif

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row"
                data-type="{{$records[0]->type}}" data-category="{{$category}}">

            <!-- include('partials.monthly-budget-'.$category) -->

            @include('partials.monthly-budget-section')

          </div><!-- .ficheck-section-type -->
      @endforeach

    </div><!-- .ficheck-sections -->
  </form>
@endsection
