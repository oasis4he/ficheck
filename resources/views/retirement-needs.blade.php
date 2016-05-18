@extends('layouts.app')

@section('content')
  <form method="post" class="retirement-needs">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$retirementNeeds->id}}">

    <div class="ficheck-sections retirement-needs-record">
      @include('layouts.title', ['title'=>'Retirement Needs'])

      @include('partials.form-errors')

      <div class="ficheck-section-type retirement-needs-type retirement-needs-type-retirement-goal row">
        <h2>Retirement Goal</h2>

        <div class="body">
          <div class="ficheck-section-body">

            @include('partials.retirement-needs-goal')

          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

      </div><!-- .ficheck-section-type -->

      <div class="ficheck-section-type retirement-needs-type retirement-needs-type-savings-investements row">
        <h2>Current Value of Savings &amp; Investments</h2>

        <div class="body">
          <div class="ficheck-section-body">

            @include('partials.retirement-needs-savings-and-investments')

          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

      </div><!-- .ficheck-section-type -->

      <div class="ficheck-section-type retirement-needs-type retirement-needs-type-future-savings-investments row">
        <h2>Future Value of Savings &amp; Investments</h2>

        <div class="body">
          <div class="ficheck-section-body">

            @include('partials.retirement-needs-future-savings-investments')

          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

      </div><!-- .ficheck-section-type -->

      <div class="ficheck-section-type retirement-needs-type retirement-needs-type-annual-savings-required row">
        <h2>Annual Savings Needed for Goal</h2>

        <div class="body">
          <div class="ficheck-section-body">

            @include('partials.retirement-needs-annual-savings-required')

          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

        <div class="col-sm-12">
            <br>
            <br>
            <br>
            <div class="control pull-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
      </div><!-- .ficheck-section-type -->

    </div><!-- .ficheck-sections -->


  </form>
@endsection
