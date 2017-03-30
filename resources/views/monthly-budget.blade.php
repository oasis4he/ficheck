@extends('layouts.app')

@section('content')
  <form method="post" action="/monthly-budget" class="budget-view {{isset($statement) ? 'readonly' : ''}} {{isset($onlyActual) ? 'onlyActual' : ''}}">
    {{ csrf_field() }}
    <input type="hidden" name="calculator" value="{{$calculator}}">
    <div class="ficheck-sections budget-view-record">

      @if($trackedMonthRecords)
        @if($trackedMonth && $trackedYear)
          @include('layouts.title', ['title'=>$title, 'month'=>$trackedMonth, 'year'=>$trackedYear])
        @else
          @include('layouts.title', ['title'=>$title])
        @endif
        @include('partials.form-errors')
        @if(isset($showTotals))
          @include('partials.monthly-budget-totals')
        @endif
        @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row"
            data-type="{{$records[0]->type}}" data-category="{{$category}}">

            <!-- include('partials.monthly-budget-'.$category) -->

            @include('partials.monthly-budget-section')

          </div><!-- .ficheck-section-type -->
        @endforeach
      @else
          <div class="well">
              This page relys on data from entries tracked in the Monthly Tracker.
              You currently don't have any tracked records in your Monthly Tracker.
              Once you start using the Monthly Tracker, you will be able to access your Monthly Budget.
          </div>
      @endif

    </div><!-- .ficheck-sections -->
  </form>
@endsection
