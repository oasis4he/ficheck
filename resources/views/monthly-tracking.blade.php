@extends('layouts.app')

@section('content')
  <div class="page-title row">

    <div class="col-xs-3">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="trackedMonthDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{$months[$currentMonth]}} {{$currentYear}}
        </button>
        <div class="dropdown-menu" aria-labelledby="trackedMonthDropdown">
          @foreach($trackedMonths as $trackedMonth)
            <a  class="dropdown-item" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$trackedMonth->id}}"> {{$months[$trackedMonth->month]}} {{$trackedMonth->year}}</a>
          @endforeach
        </div>
      </div>
    </div>

    <h1 class="col-xs-7">
      Monthly Tracking
    </h1>

    <div class="col-xs-2 toggler text-right">
      <a href="#collapse">collapse all</a>
      <a href="#expand">expand all</a>
    </div>

  </div>


  <div class="monthly-tracking">

    <div class="row header">
      <div class="col-xs-4" id="dateTrack">Date</div>
      <div class="col-xs-2" id="inTrack">In</div>
      <div class="col-xs-2" id="outTrack">Out</div>
      <div class="col-xs-4" id="categoryTrack">Category</div>
    </div>

    <div class="body">
      <form method="post">
        {{ csrf_field() }}

        <div class="row new">
          <div class="col-xs-4"><input class="form-control" name="date" type="date" aria-labelledby="dateTrack" value="{{old('date')}}"></div>
          <div class="col-xs-2"><input class="form-control" name="in" type="number" step=".01" aria-labelledby="inTrack" value="{{old('in')}}"></div>
          <div class="col-xs-2"><input class="form-control" name="out" name="out" type="number" step=".01" aria-labelledby="outTrack" value="{{old('out')}}"></div>
          <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" id="newCategory" value="{{old('category')}}"></div>
          <div class="control"><button class="btn btn-success add" class="submit">Add</button></div>
        </div>
      </form>
    </div>

    @include('partials.form-errors')

    <div class="row">
      <div class="panel-group" id="accordion">
        @foreach($trackedMonths as $month)
          <div class="panel panel-default monthly-tracking-section">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$month->id}}">
                  {{$months[$month->month]}} {{$month->year}}</a>
                </h4>
              </div>
              <div id="collapse{{$month->id}}" class="panel-collapse collapse @if($currentMonth == $month->month && $currentYear == $month->year) in @endif">
                <div class="panel-body">
                  <div class="row header">
                    <div class="col-xs-4" id="dateTrack">Date</div>
                    <div class="col-xs-2" id="inTrack">In</div>
                    <div class="col-xs-2" id="outTrack">Out</div>
                    <div class="col-xs-4" id="categoryTrack">Category</div>
                  </div>

                  <div class="body">
                    @foreach($monthlyTrackingRecords as $i=>$record)
                      @if($record->month_id != $month->id)
                        @continue
                      @endif
                      <form method="post">
                        {{ csrf_field() }}

                        <input class="form-control" name="id" type="hidden" value="{{$record->id}}">
                        <input class="form-control" name="month_id" type="hidden" value="{{$record->month_id}}">

                        <div class="row">
                          <div class="col-xs-4"><input class="form-control" name="date" type="date" aria-labelledby="dateTrack" value="{{$record->occurred_at}}"></div>
                          <div class="col-xs-2"><input class="form-control" name="in" type="number" step=".01" aria-labelledby="inTrack" value="{{$record->value>0?$record->value:''}}"></div>
                          <div class="col-xs-2"><input class="form-control" name="out" type="number" step=".01" aria-labelledby="outTrack" value="{{$record->value<0?-1*$record->value:''}}"></div>
                          <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" value="{{$record->category}}"></div>
                          <div class="control">
                            <button class="btn btn-primary save" class="submit">Save</button>
                            <a href="/monthly-tracking/delete/{{$record->id}}" class="btn btn-danger delete" class="submit">Delete</a>
                          </div>
                        </div>
                      </form>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div> {{-- closing accordian --}}

    </div>
  </div>
@endsection
