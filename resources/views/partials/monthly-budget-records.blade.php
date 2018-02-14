@foreach($records as $record)

  <div class="row valueType" data-record-id="{{$record->id}}">
    <div class="form-group col-xs-3 text-left editable" aria-label="Edit Label">
        <span class="editLabel glyphicon glyphicon-pencil" record-id="{{$record['id']}}" input-id="value_{{$record['id']}}" aria-label="Edit Label"></span>
        <label for="value_{{$record['id']}}">
          {{$record['description']}}
        </label>

      <div class="input-group deleteGroup">
        <span class="input-group-addon deleteRow" aria-label="Delete row" data-record-id="{{$record->id}}">
          <i class="glyphicon glyphicon-remove"></i>
        </span>
      </div>
    </div>
    @foreach($record['values'] as $index => $value)
            <div class="form-group col-xs-3 valueContainer {{$value['type']}}">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input name="values[{{$value['type']}}][{{$value['id']}}]"
                      {{$value['type'] == 'difference' ? 'readonly' : ''}}
                      id="value_{{$value->id}}" type="number" step="1"
                      value="{{$value['value']}}" class="form-control valueInput" aria-label="{{$record->description}} {{$value['type']}}">
                </div>
            </div>
    @endforeach
  </div>

@endforeach

<!-- Template for new fields -->
<div class="row valueType valueTypeTemplate" data-record-id="">
    <div class="form-group col-xs-3 text-left editable">
      <span class="editLabel glyphicon glyphicon-pencil" record-id="" input-id="" aria-label="Edit Label"></span>
        <label for="">

        </label>
        <div class="input-group deleteGroup">
            <span class="input-group-addon deleteRow" aria-label="Delete row"><i class="glyphicon glyphicon-remove"></i></span>
        </div>
    </div>

    <div class="form-group col-xs-3 valueContainer planned">
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input name="new_planned" id="new_planned" type="number" step="1"
                    class="form-control valueInput">
        </div>
    </div>
    <div class="form-group col-xs-3 valueContainer actual">
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input name="new_planned" id="new_planned" type="number" step="1"
                class="form-control valueInput">
        </div>
    </div>
    <div class="form-group col-xs-3 valueContainer difference">
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input name="new_planned" id="new_planned" type="number" step="1" readonly=""
                class="form-control valueInput">
        </div>
    </div>

</div>
