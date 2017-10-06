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

    @if(Auth::user()->hasRole('root'))
        <div class="col-md-6 text-right">
            <a class="btn btn-default" href="/admin/groups">Groups</a>
        </div>
    @endif
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
                    <th>Groups</th>
                    <th class="@if($sort=='first_name') @if($sortDirection == -1) headerSortUp @else headerSortDown @endif @endif "><a href="{{$users->appends(['search'=>$search,'sort'=>'first_name','direction'=>-$sortDirection])->url($page)}}">First Name</a></th>
                    <th class="@if($sort=='last_name') @if($sortDirection == -1) headerSortUp @else headerSortDown @endif @endif "><a href="{{$users->appends(['search'=>$search,'sort'=>'last_name','direction'=>-$sortDirection])->url($page)}}">Last Name</a></th>
                    <th class="@if($sort=='email') @if($sortDirection == -1) headerSortUp @else headerSortDown @endif @endif "><a href="{{$users->appends(['search'=>$search,'sort'=>'email','direction'=>-$sortDirection])->url($page)}}">Email</a></th>
                    <th class="@if($sort=='created_at') @if($sortDirection == -1) headerSortUp @else headerSortDown @endif @endif "><a href="{{$users->appends(['search'=>$search,'sort'=>'created_at','direction'=>-$sortDirection])->url($page)}}">Created</a></th>
                    {{-- <th>Graded</th> --}}
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                      {{-- only let admins add people they are over to groups, they can't add themselves --}}
                      @if($user->id != Auth::user()->id)
                        <!-- Trigger group add modal -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addGroup{{$user->id}}">Add Group</button>
                      @endif
                    </td>
                    <td>
                        @if(Auth::user()->hasRole('root') && Auth::user()->id != $user->id)
                            <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#manageRole{{$user->id}}">
                        @endif

                        @if($user->role)
                            {{$user->role->name}}
                        @else
                            User
                        @endif

                        @if(Auth::user()->hasRole('root'))
                            </button>
                        @endif
                    </td>
                    <td>
                      @if(count($user->semesters))
                          @foreach ($user->semesters as $semester)
                            <span class="badge">
                              <a href="/admin?search=group:{{$semester->id}}">{{$semester->name}}</a>
                              <a href="admin/group/delete/{{$user->id}}/{{$semester->id}}"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </span>
                          @endforeach
                      @else
                        <a href="/admin?search=group:0">&lt;none&gt;</a>
                      @endif
                    </td>
                    <td><a href="/monthly-tracking/{{$user->id}}">{{$user->first_name}}</a></td>
                    <td>{{$user->last_name}}</td>
                    <td>
                        <div>{{$user->email}}</div>
                        <div>{{$user->external_id}}</div>
                    </td>
                    <td>
                        <div>{{$user->created_at->diffForHumans()}}</div>
                        <small><div class="help-block">{{$user->created_at->format('Y-m-d H:i T')}}</div></small>
                    </td>
                    {{-- <td>
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
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- <button class="btn btn-primary pull-right">Save</button> -->
    </form>

    @foreach ($users as $user)
      <!-- Group Add Modal -->
      <div id="addGroup{{$user->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Group</h4>
            </div>
            <div class="modal-body">
              <form class="" action="admin/group/add/user/{{$user->id}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                  <label for="semester">Group Name:</label>
                  <select class="form-control" name="semester" id="semester">
                      <option></option>
                      @foreach ($semesters as $semester)
                        <option value="{{$semester->id}}">{{$semester->name}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>

      @if(Auth::user()->hasRole('root'))
        <!-- Role Manage Modal -->
        <div id="manageRole{{$user->id}}" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Role</h4>
              </div>
              <div class="modal-body">
                <form class="" action="admin/user/role/{{$user->id}}" method="post">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" name="role" id="role">
                        <option value="">User</option>
                        @foreach ($roles as $role)
                          <option value="{{$role->id}}" @if($role->id == $user->role_id) selected @endif>{{$role->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="help-block">
                      This role applies to all groups this user is a member of. If they need different roles for different groups, have them create separate accounts for each role needed.
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-default btn-success">Submit</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endforeach
</div>
<div class="text-center">
    {!! $users->appends(['search'=>$search,'sort'=>$sort,'direction'=>$sortDirection]) !!}
</div>
@stop
