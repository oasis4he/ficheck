@extends('layouts.app')

@section('content')
  <form method="post" action="/revolving-savings" class="budget-view onlyActual revolving-savings">
    {{ csrf_field() }}

    <div class="ficheck-sections monthly-budget-record">
      @include('layouts.title', ['title'=>$title])

      @include('partials.form-errors')

      @include('partials.revolving-savings-totals')


      @foreach($months as $key => $month)
          <div class="ficheck-section-type monthly-budget-type monthly-budget-type-month record-type-month row">

            @include('partials.revolving-savings-section')


          </div><!-- .ficheck-section-type -->
      @endforeach

      <button type="submit" class="btn btn-primary">Save</button>

    </div><!-- .ficheck-sections -->
  </form>
@endsection
