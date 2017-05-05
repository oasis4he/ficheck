@foreach($records as $record)
  @if(isset($trackedRecords))
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
                      id="value_{{$value->id}}" type="number" step="1"
                      value="{{$value->sum}}" class="form-control valueInput">

            </div>
        </div>
      @endif
    @endforeach
  @else
    @foreach($record['values'] as $index => $value)
       <div class="row valueType {{$value['type']}} {{($value['type'] == 'planned' && !isset($onlyActual)) || (isset($onlyActual) && $value['type'] == 'actual') ? 'active' : ''}}" data-record-id="{{$record->id}}">
           <div class="form-group col-xs-6 text-left editable" aria-label="Edit Label">
               <span class="editLabel glyphicon glyphicon-pencil" record-id="{{$record->id}}" input-id="value_{{$value->id}}"></span>
               <label for="value_{{$value->id}}">
                 {{$record->description}}
               </label>

               <div class="input-group deleteGroup">
                   <span class="input-group-addon deleteRow" aria-label="Delete row" data-record-id="{{$record->id}}">
                     <i class="glyphicon glyphicon-remove"></i>
                   </span>
               </div>
           </div>

           <div class="form-group col-xs-6">
             <input name="values[{{$value['type']}}][{{$value['id']}}]"
                     {{$value['type'] == 'difference' ? 'readonly' : ''}}
                     id="value_{{$value->id}}" type="number" step="1"
                     value="{{$value['value']}}" class="form-control valueInput">

           </div>
       </div>
   @endforeach
  @endif

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
        <input name="" id="" type="number" step="1"
                class="form-control valueInput">
    </div>
</div>
