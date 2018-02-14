@extends('layouts.app')

@section('content')
  <form method="post" action="/monthly-budget" class="budget-view {{isset($statement) ? 'readonly' : ''}} onlyActual">
    {{ csrf_field() }}
    <input type="hidden" name="calculator" value="{{$calculator}}">
    <div class="ficheck-sections budget-view-record">

    @if(count($monthlyBudgetRecords))
      @include('layouts.title', ['title'=>$title])

      @include('partials.form-errors')

        @include('partials.monthly-budget-totals')

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row" data-type="{{$records[0]->type}}" data-category="{{$category}}">
            @include('partials.ie-statement-section')
          </div><!-- .ficheck-section-type -->
      @endforeach

    @else
        <div class="well">
          You currently don't have any data in your Monthly Budget.
          Once you start using the Monthly Budget, you will be able to access your {{$title}}.
        </div>
    @endif

    </div><!-- .ficheck-sections -->
  </form>
@endsection
