@extends('layouts.app')

@section('content')
  <form method="post" class="life-insurance">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$lifeInsurance->id}}">

    <div class="ficheck-sections life-insurance-record">
      @include('layouts.title', ['title'=>'Life Insurance'])

      @include('partials.form-errors')

      <div class="ficheck-section-type life-insurance-type life-insurance-type-income-replacement row">
        <h2>Life Insurance</h2>

        <div class="body">
          <div class="ficheck-section-body">

              @include('partials.life-insurance-needs-goal')

          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

      </div><!-- .ficheck-section-type -->



    </div><!-- .ficheck-sections -->


    <div class="control pull-right">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>

  </form>
  <pre>
    Income Replacement For Survivors

    We’ll calculate your insurance needs based on 75% of your annual income. = .75 * What is your annual income?
    Total for Income Replacement = We’ll calculate your insurance needs based on 75% of your annual income. * factor

    Expenses
    Total for Income Replacement = Total for Income Replacement from previous section
    Total Expenses = sum of all other fields in this section

    Funds from other Sources
    Total Funds from other Sources = sum of other fields in this section

    Insurance Needed
    Insurance Needed = sum of all other fields in this section

  </pre>
@endsection
