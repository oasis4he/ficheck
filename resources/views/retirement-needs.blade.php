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

            <div class="row">
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
            </div><!-- .row:has(:input) -->

            <div class="row">
              <div class="form-group col-xs-12">
                <label for="annual_ss_benefit">What annual benefit will Social Security provide?</label>
                <input name="annual_ss_benefit" id="annual_ss_benefit" value="{{$retirementNeeds->annual_ss_benefit}}" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-xs-12">

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
            </div><!-- .row:has(:input) -->


            <div class="row">
              <div class="form-group col-xs-12">
                <label for="annual_employer_benefit">What annual benefit will your employer provide?</label>
                <input name="annual_employer_benefit" id="annual_employer_benefit" value="{{$retirementNeeds->annual_employer_benefit}}" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-xs-12">

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
            </div><!-- .row:has(:input) -->

            <div class="row">
              <div class="form-group col-xs-12">
                <label for="additional_annual_income_required">The additional annual income you will need:</label>
                <input name="additional_annual_income_required" id="additional_annual_income_required" value="{{$retirementNeeds->additional_annual_income_required}}" class="form-control" readonly>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-xs-12">

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
            </div><!-- .row:has(:input) -->


            <div class="row">
              <div class="form-group col-xs-12">
                <label for="desired_retirement_age">Choose the number closest to the age you plan to retire.</label>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <select name="desired_retirement_age" id="desired_retirement_age" class="form-control">
                  <option></option>

                  @foreach(['55'=>21,'60'=>18.9,'65'=>16.4,'70'=>13.6] as $age=>$factor)
                    <option @if($retirementNeeds->desired_retirement_age==$age) value="{{$retirementNeeds->desired_retirement_age}}" @endif data-factor="{{$factor}}">{{$age}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-xs-6">
                <input name="retirment_age_factor" id="retirment_age_factor" value="{{$retirementNeeds->retirment_age_factor}}" class="form-control" readonly>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-xs-12">

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
            </div><!-- .row:has(:input) -->

            <div class="row">
              <br><br>
              <div class="form-group col-xs-12">
                <label for="retirment_goal">Retirement Goal</label>
                <br>
                multiply anual income needed by factor to get goal
                <input name="retirment_goal" id="retirment_goal" value="{{$retirementNeeds->retirment_goal}}" class="form-control" readonly>
              </div>
            </div>

          </div><!-- .ficheck-section-body -->

        </div><!-- .body -->

      </div><!-- .ficheck-section-type -->

    </div><!-- .ficheck-sections -->

    <pre>
      Current Value of Savings & Investments
      calculate Current Value of Savings/Investments by adding 3 previous fields

      Future Value of Savings & Investments
      calculate Future Value of Savings/Investments = Current Value of Savings/Investments * previous age factor

      Annual Savings Needed for Goal = This is the additional savings that you will need for retirement. = Enter your Retirement Goal - Enter your Savings/Investments Future Value

      pre populate age value from savings and investments age value
      Annual Savings needed to reach your Retirement Goal. = This is the additional savings that you will need for retirement. / factor
    </pre>

    <div class="control pull-right">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>

  </form>
@endsection
