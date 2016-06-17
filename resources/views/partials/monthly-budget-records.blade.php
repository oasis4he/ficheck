@foreach($records as $record)
    <div class="row">
        <div class="form-group col-xs-6 text-left">
            <label for="record_{{$record->id}}">{{$record->description}}</label>
        </div>

        <div class="form-group col-xs-6">
            <input name="record_{{$record->id}}" id="record_{{$record->id}}" value="" class="form-control">
        </div>
    </div>
@endforeach
