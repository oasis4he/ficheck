<form method="post" class="financial-ratio">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{$ratio->id}}">
  <input type="hidden" name="financial_ratio_type_id" value="{{$ratioType->id}}">

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="asset">{{$ratioType->asset_label}}</label>
      <input name="asset" id="asset" type="number" value="{{$ratio->asset}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      @if($ratioType->asset_link)
        <a class="pull-right" href="{{$ratioType->asset_link}}">{{$ratioType->asset_link_text}}</a>
      @endif

      <div class="help-controls">
        <a href="#show-help">show help</a>
        <a href="#hide-help" class="hide">hide help</a>
      </div>

    </div>
    <div class="description">
      <div class="description-content">
        {!! $ratioType->asset_description !!}
      </div>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="liability">{{$ratioType->liability_label}}</label>
      <input name="liability" id="liability" type="number" value="{{$ratio->liability}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      @if($ratioType->liability_link)
        <a class="pull-right" href="{{$ratioType->liability_link}}">{{$ratioType->liability_link_text}}</a>
      @endif

      <div class="help-controls">
        <a href="#show-help">show help</a>
        <a href="#hide-help" class="hide">hide help</a>
      </div>

    </div>
    <div class="description">
      <div class="description-content">
        {!! $ratioType->liability_description !!}
      </div>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="ratio">{{$ratioType->ratio_label}}</label>
      <input name="ratio" id="ratio" type="number" value="{{$ratio->ratio}}" class="form-control ratio-output" readonly>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <div class="help-controls">
        <a href="#show-help">show help</a>
        <a href="#hide-help" class="hide">hide help</a>
      </div>

    </div>
    <div class="description">
      <div class="description-content">
        {!! $ratioType->ratio_description !!}
      </div>
    </div>
  </div>

  <div class="control">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
