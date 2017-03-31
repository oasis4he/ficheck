@extends('layouts.app')

@section('content')

<div class="row">
    <form method="get" class="search col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Name, email, A-Number, Role" name="search" value="{{Request::get('search')}}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit" aria-label="Search"><i class="glyphicon glyphicon-search"></i></button>
            </span>
        </div>
        @if(Request::get('search'))
            <a href="/admin">clear search</a>
        @endif
    </form>
</div>
<hr>
<div class="row">
    <form method="post" action="/admin/grade">
        {!! csrf_field() !!}
        <table class="table striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Role</th>
                    <th>Semester Group</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>A-Number</th>
                    <th>Graded</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                      <!-- Trigger group add modal -->
                      <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addGroup{{$user->id}}">Add Group</button>
                    </td>
                    <td>
                        @if($user->role)
                            {{$user->role->name}}
                        @endif
                    </td>
                    <td>
                      @if($user->semesters)
                          @foreach ($user->semesters as $semester)
                            <span class="badge">
                              {{$semester->name}}
                              <a href="admin/group/delete/{{$user->id}}/{{$semester->id}}"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </span>
                          @endforeach
                      @endif
                    </td>
                    <td><a href="/monthly-tracking/{{$user->id}}">{{$user->first_name}}</a></td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->external_id}}</td>
                    <td>
                        <div class="form-group" @if($user->graded_at) title="Grader: {{$user->grader->name}} ({{$user->graded_at}})" @endif>
                            <label>
                                <input type="radio" name="graded[{{$user->id}}]" value="1" @if($user->graded_at) checked @endif>
                                graded
                            </label> &nbsp;
                            <label>
                                <input type="radio" name="graded[{{$user->id}}]" value="0" @if(!$user->graded_at) checked @endif >
                                no grade
                            </label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-primary pull-right">Save</button>
    </form>

    @foreach ($users as $user)
      <!-- Group Add Modal -->
      <div id="addGroup{{$user->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Semester Group</h4>
            </div>
            <div class="modal-body">
              <form class="" action="admin/group/add/user/{{$user->id}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                  <label for="semester">Semester:</label>
                  <select class="form-control" name="semester" id="semester">
                    @foreach ($semesters as $semester)
                      <option value="{{$semester->id}}">{{$semester->name}}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-default btn-success">Submit</button>
              </form>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>

        </div>
      </div>
    @endforeach
</div>
<div class="text-center">
    {!! $users->render() !!}
</div>
@stop
