@extends('layouts.app')

@section('content')
  <form method="post" class="retirement-needs">
    {{ csrf_field() }}
    <div class="ficheck-sections retirement-needs-record">
      @include('layouts.title', ['title'=>'Monthly Budget'])

      @include('partials.form-errors')

      @foreach($monthlyBudgetRecords->groupBy('category') as $category=>$records)
          <div class="ficheck-section-type retirement-needs-type retirement-needs-type-{{$category}} row">

            @include('partials.monthly-budget-'.$category)

          </div><!-- .ficheck-section-type -->
      @endforeach

    </div><!-- .ficheck-sections -->

  </form>
@endsection
