@extends('layouts.app')

@section('content')
<div class="container monthly-tracking">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Monthly Tracking

                  <button class="btn btn-primary btn-xs pull-right" type="submit">Save</button>
                </div>

                <div class="panel-body">
                  <form method="post">
                    {{ csrf_field() }}

                    @if (count($errors) > 0)
                      <div class="alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    <table>
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>In</th>
                          <th>Out</th>
                          <th>Category</th>
                        </tr>
                      </thead>
                      @foreach($monthlyTrackingRecords as $record)
                        <tr>
                          <td><input class="form-control" name="date" type="date" value="{{$record->occurred_at}}"></td>
                          <td><input class="form-control" name="in" type="number" value="{{$record->value>0?$record->value:''}}"></td>
                          <td><input class="form-control" name="out" type="number" value="{{$record->value<0?-1*$record->value:''}}"></td>
                          <td><input class="form-control" name="category" type="text" value="{{$record->category}}"></td>
                        </tr>
                      @endforeach
                    </table>

                    <table class="new-record-template">
                      <tr>
                        <td><input class="form-control" name="date" type="date" value="{{old('date')}}"></td>
                        <td><input class="form-control" name="in" type="number" value="{{old('in')}}"></td>
                        <td><input class="form-control" name="out" type="number" value="{{old('out')}}"></td>
                        <td><input class="form-control" name="category" type="text" value="{{old('category')}}"></td>
                        <td><button class="btn btn-success add btn-xs">Add</button></td>
                      </tr>
                    </table>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
