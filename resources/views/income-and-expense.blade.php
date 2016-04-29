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

            <!-- <div class="row">
              <div class="form-group col-xs-12">
                <label for="annual_income">What annual income will you need for retirement?</label>
                <input name="annual_income" id="annual_income" value="{{$retirementNeeds->annual_income}}" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-xs-12">
                <a class="pull-right" href="/net-worth">view Net Worth Statement</a>

                <div class="help-controls">
                  <a href="#show-help">show help</a>
                  <a href="#hide-help" class="hide">hide help</a>
                </div>

              </div>
              <div class="description">
                <div class="description-content">
                  &lt;-- help text --&gt;
                </div>
              </div>
            </div><!-- .row:has(:input) --> -->

            <pre>
              not supposed to have planned/actual and difference?? annually? not sure on this one yet...
            </pre>
          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

      </div><!-- .ficheck-section-type -->

    </div><!-- .ficheck-sections -->


    <div class="control pull-right">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>

  </form>
@endsection
