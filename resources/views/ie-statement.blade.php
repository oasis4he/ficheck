@extends('layouts.app')

@section('content')
  <form method="post" action="/monthly-budget" class="budget-view {{isset($statement) ? 'readonly' : ''}} onlyActual">
    {{ csrf_field() }}
    <input type="hidden" name="calculator" value="{{$calculator}}">
    <div class="ficheck-sections budget-view-record">

    @if($trackedMonthRecords)
      @include('layouts.title', ['title'=>$title])

      @include('partials.form-errors')

      @if($trackedMonth && $trackedYear)
        <div class="row">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="trackedMonthDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{$trackedMonth}} {{$trackedYear}}
                <i class="fa fa-chevron-down dropdown-caret" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="trackedMonthDropdown">
                @foreach($trackedMonths as $trackedMonth)
                  <a  class="dropdown-item" data-parent="#accordion" href="?month={{$trackedMonth->month}}&year={{$trackedMonth->year}}"> {{$months[$trackedMonth->month]}} {{$trackedMonth->year}}</a>
                @endforeach
              </div>
            </div>
        </div>
      @endif

        @include('partials.monthly-budget-totals')

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row"
                data-type="{{$records[0]->type}}" data-category="{{$category}}">

            <!-- include('partials.monthly-budget-'.$category) -->

            @include('partials.ie-statement-section')

          </div><!-- .ficheck-section-type -->
      @endforeach

    @else
        @if($trackedMonth && $trackedYear)
          <div class="row">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="trackedMonthDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{$trackedMonth}} {{$trackedYear}}
                  <i class="fa fa-chevron-down dropdown-caret" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="trackedMonthDropdown">
                  @foreach($trackedMonths as $trackedMonth)
                    <a  class="dropdown-item" data-parent="#accordion" href="?month={{$trackedMonth->month}}&year={{$trackedMonth->year}}"> {{$months[$trackedMonth->month]}} {{$trackedMonth->year}}</a>
                  @endforeach
                </div>
              </div>
          </div>
        @endif
        @include('partials.monthly-tracker-message')
    @endif

    </div><!-- .ficheck-sections -->
  </form>
@endsection
