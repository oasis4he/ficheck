@foreach($records as $record)

  <div class="row valueType" data-record-id="{{$record->id}}">
    <div class="form-group col-xs-3 text-left editable">
      <span class="section-header">
        {{$record->description}}
      </span>

      <div class="input-group deleteGroup">
        <span class="input-group-addon deleteRow" aria-label="Delete row" data-record-id="{{$record->id}}">
          <i class="glyphicon glyphicon-remove"></i>
        </span>
      </div>
    </div>
    @foreach($record['values'] as $index => $value)
            <div class="form-group col-xs-3 valueContainer {{$value['type']}}">
              <input name="values[{{$value['type']}}][{{$value['id']}}]"
                      {{$value['type'] == 'difference' ? 'readonly' : ''}}
                      id="value_{{$value->id}}" type="number" step="1"
                      value="{{$value['value']}}" class="form-control valueInput" aria-label="{{$record->description}} {{$value['type']}}">

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
        <input name="" id="" type="number" step="1"
                class="form-control valueInput">
    </div>
</div>
