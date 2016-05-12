@extends('layouts.app')

@section('content')
  <div class="page-title row">
    <h1 class="col-xs-7">Monthly Tracking</h1>
    <!-- <div class="col-xs-5 toggler text-right">
      <a href="#categories">categories</a>
    </div> -->
  </div>


  <div class="monthly-tracking">

    @include('partials.form-errors')

    <div class="row header">
      <div class="col-xs-4">Date</div>
      <div class="col-xs-2">In</div>
      <div class="col-xs-2">Out</div>
      <div class="col-xs-4">Category</div>
    </div>

    <div class="body">
      @foreach($monthlyTrackingRecords as $i=>$record)
      <form method="post">
        {{ csrf_field() }}

        <input class="form-control" name="id" type="hidden" value="{{$record->id}}">

        <div class="row">
          <div class="col-xs-4"><input class="form-control" name="date" type="text" value="{{$record->occurred_at}}"></div>
          <div class="col-xs-2"><input class="form-control" name="in" type="text" value="{{$record->value>0?$record->value:''}}"></div>
          <div class="col-xs-2"><input class="form-control" name="out" type="text" value="{{$record->value<0?-1*$record->value:''}}"></div>
          <div class="col-xs-4"><input class="form-control" name="category" type="text" value="{{$record->category}}"></div>
          <div class="control">
            <button class="btn btn-primary save" class="submit">Save</button>
            <a href="/monthly-tracking/delete/{{$record->id}}" class="btn btn-danger delete" class="submit">Delete</a>
          </div>
        </div>
      </form>
      @endforeach

      <form method="post">
        {{ csrf_field() }}

        <div class="row new">
          <div class="col-xs-4"><input class="form-control" name="date" type="text" value="{{old('date')}}"></div>
          <div class="col-xs-2"><input class="form-control" name="in" type="text" value="{{old('in')}}"></div>
          <div class="col-xs-2"><input class="form-control" name="out" type="text" value="{{old('out')}}"></div>
          <div class="col-xs-4"><input class="form-control" name="category" type="text" value="{{old('category')}}"></div>
          <div class="control"><button class="btn btn-success add" class="submit">Add</button></div>
        </div>
      </form>
    </div>
  </div>
@endsection
