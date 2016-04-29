@extends('layouts.app')

@section('content')
  <div class="ficheck-sections financial-ratios">
    @include('layouts.title', ['title'=>'Financial Ratios'])

    @include('partials.form-errors')

    @foreach($ratioTypes as $ratioType)
      <div class="ficheck-section-type financial-ratio-type financial-ratio-type-{{$ratioType->slug}} row">
        <h2>{{$ratioType->title}}</h2>

        @if($ratioType->records->count() > 0)
          <div class="body">
            @include('partials.financial-ratio', ['ratio'=>$ratioType->records[0]])
          </div>
        @else
          <div class="body">
            @include('partials.financial-ratio', ['ratio'=>new \App\FinancialRatioRecord()])
          </div>
        @endif
      </div>
    @endforeach
  </div>
@endsection
