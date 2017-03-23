@foreach($records as $record)

  <div class="row valueType" data-record-id="{{$record->id}}">
    <div class="form-group col-xs-3 text-left editable" aria-label="Edit Label">
      <label for="">
        {{$record->description}}
      </label>

      <div class="input-group deleteGroup">
        <span class="input-group-addon deleteRow" aria-label="Delete row" data-record-id="{{$record->id}}">
          <i class="glyphicon glyphicon-remove"></i>
        </span>
      </div>
    </div>
    @foreach($record['values'] as $index => $value)
            <div class="form-group col-xs-3">
              <input name="values[{{$value['type']}}][{{$value['id']}}]"
                      {{$value['type'] == 'difference' ? 'readonly' : ''}}
                      id="value_{{$value->id}}" type="number" step=".01"
                      value="{{$value['value']}}" class="form-control valueInput">

            </div>
    @endforeach
  </div>

@endforeach

<!-- Template for new fields -->
<div class="row valueType valueTypeTemplate" data-record-id="">
    <div class="form-group col-xs-6 text-left editable">

        <label for="">

        </label>
        <div class="input-group deleteGroup">
            <span class="input-group-addon deleteRow" aria-label="Delete row"><i class="glyphicon glyphicon-remove"></i></span>
        </div>
    </div>

    <div class="form-group col-xs-6">
        <input name="" id="" type="number" step=".01"
                class="form-control valueInput">
    </div>
</div>
