@extends('layouts.app')

@section('content')
  <form method="post" action="/monthly-budget" class="budget-view readonly onlyActual">
    {{ csrf_field() }}
    <input type="hidden" name="calculator" value="{{$calculator}}">
    <div class="ficheck-sections budget-view-record">

    @if($trackedMonthRecords)
      @include('layouts.title', ['title'=>$title, 'month'=>$trackedMonth, 'year'=>$trackedYear])

      @include('partials.form-errors')

        @include('partials.monthly-budget-totals')

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row"
                data-type="{{$records[0]->type}}" data-category="{{$category}}">

            <!-- include('partials.monthly-budget-'.$category) -->

            @include('partials.ie-statement-section')

          </div><!-- .ficheck-section-type -->
      @endforeach

    @else
        <div class="well">
            The Monthly Budget relys on data from entries tracked in the Monthly Tracker.
            You currently don't have any tracked records for your most recent tracked month of {{$trackedMonth}} {{$trackedYear}}.
            You will need to update the Montly Tracker for the month of {{$trackedMonth}} {{$trackedYear}} in order to access your Monthly Budget.
        </div>
    @endif

    </div><!-- .ficheck-sections -->
  </form>
@endsection
