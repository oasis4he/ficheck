<div class="page-title row">
  @if(isset($month))
    <h1 class="col-sm-7">{{$title}} - {{$month}} {{$year}}</h1>
  @else
    <h1 class="col-sm-7">{{$title}}</h1>
  @endif
  <div class="col-sm-5 toggler text-right">
    <a href="#collapse">collapse all</a>
    <a href="#expand">expand all</a>
  </div>
</div>
