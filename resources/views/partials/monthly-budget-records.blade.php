@foreach($records as $record)

    @foreach($record['values'] as $index => $value)
        <div class="row valueType {{$value['type']}} {{$value['type'] == 'planned' ? 'active' : ''}}" data-record-id="{{$record->id}}">
            <div class="form-group col-xs-6 text-left editable">
                <label for="value_{{$value->id}}">
                  {{$record->description}}
                </label>
                 <button class="editLabel" type="button" record-id="{{$record->id}}" input-id="value_{{$value->id}}">Edit</button>
            </div>

            <div class="form-group col-xs-6">
                <input name="values[{{$value['type']}}][{{$value['id']}}]"
                        {{$value['type'] == 'difference' ? 'readonly' : ''}}
                        id="value_{{$value->id}}" type="number" step=".01"
                        value="{{$value['value']}}" class="form-control valueInput">

            </div>
        </div>
    @endforeach

@endforeach


<!-- Template for new fields -->
<div class="row valueType valueTypeTemplate" data-record-id="">
    <div class="form-group col-xs-6 text-left editable">
        <label for="">

        </label>
         <button class="editLabel" type="button" record-id="" input-id="">Edit</button>
    </div>

    <div class="form-group col-xs-6">
        <input name="" id="" type="number" step=".01"
                class="form-control valueInput">
    </div>
</div>
