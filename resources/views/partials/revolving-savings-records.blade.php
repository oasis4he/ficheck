@if(isset($revolvingSavingsRecord[$key]))
    @foreach($revolvingSavingsRecord[$key] as $recordKey => $record)
        <div class="row valueType actual active" data-record-id="{{$record['id']}}">
            <div class="form-group col-xs-6 text-left editable" aria-label="Edit Label">
                <span class="editLabel glyphicon glyphicon-pencil" record-id="{{$record['id']}}" input-id="value_{{$record['id']}}"></span>
                <label for="value_{{$record['id']}}">
                  {{$record['description']}}
                </label>

                <div class="input-group deleteGroup">
                    <span class="input-group-addon deleteRow" aria-label="Delete row" data-record-id="{{$record['id']}}">
                      <i class="glyphicon glyphicon-remove"></i>
                    </span>
                </div>
            </div>

            <div class="form-group col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input name="names[{{$record['id']}}][value]"
                      id="value_{{$record['id']}}" type="number" step="1"
                      value="{{$record['value']}}" class="form-control valueInput">
                </div>
            </div>
        </div>

    @endforeach
@endif


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
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input name="" id="" type="number" step="1"
                class="form-control valueInput">
        </div>
    </div>
</div>
