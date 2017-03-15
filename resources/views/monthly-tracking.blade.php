@extends('layouts.app')

@section('content')
  <div class="page-title row">
    <h1 class="col-xs-7">
      <select class="" name="">
        @foreach ($months as $key => $value)
          <option value="{{$key}}" @if($key == $currentMonth) selected @endif>{{$value}}</option>
        @endforeach
      </select>
      <select class="" name="">
        @foreach ($years as $year)
          <option value="{{$year}}" @if($year == $currentYear) selected @endif>{{$year}}</option>
        @endforeach
      </select>
      Monthly Tracking
    </h1>
    <!-- <div class="col-xs-5 toggler text-right">
      <a href="#categories">categories</a>
    </div> -->
  </div>


  <div class="monthly-tracking">

    @include('partials.form-errors')
    <div class="row">
      <div class="panel-group" id="accordion">
        @foreach ($years as $year)
          @foreach ($months as $key => $value)
            @if($currentMonth < $key && $currentYear == $year)
              @continue
            @endif
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$key}}{{$year}}">
                    {{$value}} {{$year}}</a>
                  </h4>
                </div>
                <div id="collapse-{{$key}}{{$year}}" class="panel-collapse collapse @if($currentMonth == $key && $currentYear == $year) in @endif">
                  <div class="panel-body">
                    <div class="row header">
                      <div class="col-xs-4" id="dateTrack">Date</div>
                      <div class="col-xs-2" id="inTrack">In</div>
                      <div class="col-xs-2" id="outTrack">Out</div>
                      <div class="col-xs-4" id="categoryTrack">Category</div>
                    </div>

                    <div class="body">
                      @foreach($monthlyTrackingRecords as $i=>$record)
                        {{-- @if($record->trackedMonth->month == $key && $record->trackedMonth->year == $year) --}}
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
                        {{-- @endif --}}
                      @endforeach

                      <form method="post">
                        {{ csrf_field() }}
                        <input class="form-control" name="month" type="hidden" value="{{$key}}">
                        <input class="form-control" name="year" type="hidden" value="{{$year}}">

                        <div class="row new">
                          <div class="col-xs-4"><input class="form-control" name="date" type="date" aria-labelledby="dateTrack" value="{{old('date')}}"></div>
                          <div class="col-xs-2"><input class="form-control" name="in" type="number" step=".01" aria-labelledby="inTrack" value="{{old('in')}}"></div>
                          <div class="col-xs-2"><input class="form-control" name="out" name="out" type="number" step=".01" aria-labelledby="outTrack" value="{{old('out')}}"></div>
                          <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" value="{{old('category')}}"></div>
                          <div class="control"><button class="btn btn-success add" class="submit">Add</button></div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach

          @endforeach
        </div>
    </div>
@endsection
