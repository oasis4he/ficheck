@extends('layouts.app')

@section('content')
  <form method="post" class="retirement-needs">
    {{ csrf_field() }}
    <div class="ficheck-sections retirement-needs-record">
      @include('layouts.title', ['title'=>$title])

      @include('partials.form-errors')

      @if(isset($statement))
        show sums...
      @else
        show buttons...
      @endif

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-{{$category}} record-type-{{$records[0]->type}} row">

            @include('partials.monthly-budget-'.$category)

          </div><!-- .ficheck-section-type -->
      @endforeach

    </div><!-- .ficheck-sections -->

  </form>
@endsection
