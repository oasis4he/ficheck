@extends('layouts.app')

@section('content')
  <form method="post" class="budget-view">
    {{ csrf_field() }}
    <div class="ficheck-sections budget-view-record">
      @include('layouts.title', ['title'=>$title])

      @include('partials.form-errors')

      @if(isset($statement))
        show sums...
      @else
      <div class="row">
        <div class="pull-right">
          <button type="button" class="toggleBudgetInputs planned active">P</button>
          <button type="button" class="toggleBudgetInputs actual">A</button>
          <button type="button" class="toggleBudgetInputs difference">+/-</button>
        </div>
      </div>

      @endif

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row">

            @include('partials.monthly-budget-'.$category)

          </div><!-- .ficheck-section-type -->
      @endforeach

    </div><!-- .ficheck-sections -->

  </form>
@endsection
