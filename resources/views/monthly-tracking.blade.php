@extends('layouts.app')

@section('content')

  @include('layouts.title', ['title'=>$title])


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
          <div class="col-xs-4"><input class="form-control" name="date" type aria-labelledby="dateTrack" value="{{old('date')}}" @if($saved) autofocus @endif></div>
          <div class="col-xs-2"><input class="form-control" name="in" type="number" step="1" aria-labelledby="inTrack" value="{{old('in')}}"></div>
          <div class="col-xs-2"><input class="form-control" name="out" name="out" type="number" step="1" aria-labelledby="outTrack" value="{{old('out')}}"></div>
          <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" id="newCategory" value="{{old('category')}}"></div>
          <div class="control">
            <a href="#add" class="btn btn-success add" class="submit">Add</a>
          </div>
        </div>
      </form>
    </div>

    <div class="row">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="trackedMonthDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{$months[$currentMonth]}} {{$currentYear}}
            <i class="fa fa-chevron-down dropdown-caret" aria-hidden="true"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="trackedMonthDropdown">
            @foreach($trackedMonths as $trackedMonth)
              <a  class="dropdown-item" data-parent="#accordion" href="#{{$months[$trackedMonth->month]}}{{$trackedMonth->year}}">
                <span class="dropdown-month hide">{{$trackedMonth->month}}</span>
                <span class="dropdown-year hide">{{$trackedMonth->year}}</span>
                <span>
                  {{$months[$trackedMonth->month]}} {{$trackedMonth->year}}
                </span>
              </a>
            @endforeach
          </div>
        </div>
    </div>

    @include('partials.form-errors')

    <div class="row">
      <div class="panel-group" id="accordion">
        @foreach($trackedMonths as $trackedMonth)
          <div class="panel panel-default monthly-tracking-section" id="{{$trackedMonth->id}}">
            <span class="panel-month hide">{{$trackedMonth->month}}</span>
            <span class="panel-year hide">{{$trackedMonth->year}}</span>

            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#{{$months[$trackedMonth->month]}}{{$trackedMonth->year}}">
                  {{$months[$trackedMonth->month]}} {{$trackedMonth->year}}</a>
                  <!-- Trigger the modal with a button -->
                  <a type="button" class="pull-right" data-toggle="modal" data-target="#newEntryModal" href="#newEntryModal" aria-label="{{$trackedMonth}} add new Entry"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </h4>
              </div>
              <div id="{{$months[$trackedMonth->month]}}{{$trackedMonth->year}}" class="panel-collapse collapse @if($currentMonth == $trackedMonth->month && $currentYear == $trackedMonth->year) in @endif">
                <div class="panel-body">
                  <div class="row header">
                    <div class="col-xs-4" id="dateTrack">Date</div>
                    <div class="col-xs-2" id="inTrack">In</div>
                    <div class="col-xs-2" id="outTrack">Out</div>
                    <div class="col-xs-4" id="categoryTrack">Category</div>
                  </div>

                  <div class="body">
                    @foreach($monthlyTrackingRecords as $i=>$record)
                      @if($record->month_id != $trackedMonth->id)
                        @continue
                      @endif
                      <form method="post" class="edit">
                        {{ csrf_field() }}

                        <input class="form-control" name="id" type="hidden" value="{{$record->id}}">
                        <input class="form-control" name="month_id" type="hidden" value="{{$record->month_id}}">

                        <div class="row">
                          <div class="col-xs-4"><input class="form-control" name="date" type aria-labelledby="dateTrack" value="{{$record->occurred_at}}"></div>
                          <div class="col-xs-2"><input class="form-control" name="in" type="number"  step="1" aria-labelledby="inTrack" value="{{$record->value>0?$record->value:''}}"></div>
                          <div class="col-xs-2"><input class="form-control" name="out" type="number" step="1" aria-labelledby="outTrack" value="{{$record->value<0?-1*$record->value:''}}"></div>
                          <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" value="{{$record->category}}"></div>
                          <div class="control">
                            <a href="#delete" class="btn btn-danger delete" class="submit">Delete</a>
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

        <!-- Modal -->
        <div id="newEntryModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Entry</h4>
              </div>
              <div class="modal-body">
                <div class="row header">
                  <div class="col-xs-4" id="dateTrack">Date</div>
                  <div class="col-xs-2" id="inTrack">In</div>
                  <div class="col-xs-2" id="outTrack">Out</div>
                  <div class="col-xs-4" id="categoryTrack">Category</div>
                </div>

                <div class="body">
                  <form method="post" class="ui-front">
                    {{ csrf_field() }}

                    <div class="row new">
                      <div class="col-xs-4"><input class="form-control" name="date" type aria-labelledby="dateTrack" value="{{old('date')}}"></div>
                      <div class="col-xs-2"><input class="form-control" name="in" type="number" step="1" aria-labelledby="inTrack" value="{{old('in')}}"></div>
                      <div class="col-xs-2"><input class="form-control" name="out" name="out" type="number" step="1" aria-labelledby="outTrack" value="{{old('out')}}"></div>
                      <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" id="newCategory" value="{{old('category')}}"></div>
                      <div class="control">
                        <a href="#add" class="btn btn-success add" class="submit">Add</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

          <!-- Modal -->
          <div id="errorModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content panel-danger">
                <div class="modal-header panel-heading">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                  <p></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>


    </div>
  </div>
@endsection
