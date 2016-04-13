@extends('layouts.app')

@section('content')
  <div class="financial-goals">
    @include('layouts.title', ['title'=>'Financial Goals'])

    @foreach($goalTypes as $goalType)
      <div class="financial-goal-type financial-goal-type-{{$goalType->slug}}">
        <h2>{{$goalType->title}}s | {{$goalType->description}}</h2>

        @foreach($goalType->goals as $goal)
          <div class="body">
            @include('partials.financial-goal', ['goal'=>$goal])
          <div>
        @endforeach

        <div class="template">
          @include('partials.financial-goal', ['goal'=>new \App\FinancialGoal()])
        </div>

        <a href="#add">add {{strtolower($goalType->title)}}</a>
      </div>
    @endforeach
  </div>
@endsection
