@foreach($records as $record)

    @foreach($trackedRecords as $value)
      @if($value->category == $record->description)
        <div class="row valueType actual active " data-record-id="{{$record->id}}">
            <div class="form-group col-xs-6 text-left editable" >
                <label for="value_{{$value->id}}">
                  {{$record->description}}
                </label>
            </div>

            <div class="form-group col-xs-6">
              <input name="values[{{$value->category}}][{{$value->id}}]"
                      id="value_{{$value->id}}" type="number" step=".01"
                      value="{{$value->sum}}" class="form-control valueInput">

            </div>
        </div>
      @endif
    @endforeach

@endforeach

<!-- Template for new fields -->
<div class="row valueType valueTypeTemplate" data-record-id="">
    <div class="form-group col-xs-6 text-left editable">
        <span class="editLabel glyphicon glyphicon-pencil" record-id="" input-id="" aria-label="Edit Label"></span>

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
