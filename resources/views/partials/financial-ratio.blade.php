<form method="post" class="financial-ratio">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{$ratio->id}}">
  <input type="hidden" name="financial_ratio_type_id" value="{{$ratioType->id}}">

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="asset">{{$ratioType->asset_label}}</label>
      <input name="asset" id="description" value="{{$ratio->description}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <a>test</a>
      <a>test</a>
      <a>test</a>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="plan" value = "test">{{$ratioType->liability_label}}</label>
      <input name="plan" id="plan" value="{{$ratio->slug}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="cost">{{$ratioType->ratio_label}}</label>
      <input name="cost" id="cost" value="{{$ratio->cost}}" class="form-control">
    </div>
  </div>

  <div class="control">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>

<!-- Old code
<form method="post" class="financial-ratio">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{$ratio->id}}">
  <input type="hidden" name="financial_ratio_type_id" value="{{$ratioType->id}}">

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="description">Description</label>
      <input name="description" id="description" value="{{$ratio->description}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="plan">Plan</label>
      <input name="plan" id="plan" value="{{$ratio->plan}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-6">
      <label for="cost">Cost</label>
      <input name="cost" id="cost" value="{{$ratio->cost}}" class="form-control">
    </div>

    <div class="form-group col-xs-6">
      <label for="date">Date</label>
      <input name="date" id="date" value="{{$ratio->date}}" class="form-control">
    </div>
  </div>

  <div class="control">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form> -->
