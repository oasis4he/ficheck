@extends('layouts.app')

@section('content')
  <div class="financial-goals">
    @include('layouts.title', ['title'=>'Financial Goals'])

    @include('partials.form-errors')

    @foreach($goalTypes as $goalType)
      <div class="financial-goal-type financial-goal-type-{{$goalType->slug}} row">
        <h2>{{$goalType->title}}s | {{$goalType->description}}</h2>

        @foreach($goalType->goals as $goal)
          <div class="body">
            @include('partials.financial-goal', ['goal'=>$goal])
          </div>
        @endforeach

        <div class="template">
          @include('partials.financial-goal', ['goal'=>new \App\FinancialGoal()])
        </div>

        @if(count($goalType->goals))
          <a href="#add">add {{strtolower($goalType->title)}}</a>
        @endif
      </div>
    @endforeach
  </div>
@endsection
