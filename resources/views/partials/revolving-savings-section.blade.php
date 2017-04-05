<h2>{{$month}}</h2>

<div class="body month" data-month="{{$key}}" data-month-name="{{$month}}">
  <div class="ficheck-section-body">

    @include('partials.revolving-savings-records')

    <div class="row newItem">
        <div class="form-group col-xs-6 text-left">
            <label for="new_{{$month}}">Add an Item</label>
        </div>
    </div>

  </div><!-- .ficheck-section-body -->


</div><!-- .body -->
