@extends('layouts.app')

@section('content')
  <div class="ficheck-sections financial-ratios">
    @include('layouts.title', ['title'=>'Financial Ratios'])

    @include('partials.form-errors')

    @foreach($ratioTypes as $ratioType)
      <div class="ficheck-section-type financial-ratio-type financial-ratio-type-{{$ratioType->slug}} row">
        <h2>{{$ratioType->title}}</h2>

        @foreach($ratioType->records as $ratio)
          <div class="body">
            @include('partials.financial-ratio', ['record'=>$ratio])
          </div>
        @endforeach

        <div class="template">
          @include('partials.financial-ratio', ['ratio'=>new \App\FinancialRatioRecord()])
        </div>
      </div>
    @endforeach
  </div>
@endsection
