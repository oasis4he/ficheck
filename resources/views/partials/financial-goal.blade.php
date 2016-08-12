<form method="post" class="financial-goal">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{$goal->id}}">
  <input type="hidden" name="financial_goal_type_id" value="{{$goalType->id}}">

  <div class="row">
    <div class="form-group col-xs-12">
      <a href="/financial-goals/delete/{{$goal->id}}" class="badge badge-warning delete pull-right">X</a>

      <label for="description">Description</label>
      <input name="description" id="description" value="{{$goal->description}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <label for="plan">Plan</label>
      <input name="plan" id="plan" value="{{$goal->plan}}" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-6">
      <label for="cost">Cost</label>
      <input name="cost" id="cost" type="number" value="{{$goal->cost}}" class="form-control">
    </div>

    <div class="form-group col-xs-6">
      <label for="date">Date</label>
      <input name="date" id="date" type="date" value="{{$goal->date}}" class="form-control">
    </div>
  </div>

  <div class="control">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
