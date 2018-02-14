@extends('layouts.app')

@section('content')

<div class="row">
    <form method="get" class="search">
        <div class="col-md-6">
            <div>
                <label for="group">Group</label>
                <select name="group" id="group">
                    <option value="">All</option>
                    @foreach($groups as $group)
                        <option value="{{$group->slug ? $group->slug : $group->id }}" @if($group->slug == $groupFilter || $group->id == $groupFilter) selected @endif>{{$group->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Name, email, Role" name="search" value="{{Request::get('search')}}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" aria-label="Search"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
            @if(Request::get('search'))
                <a href="/admin">clear search</a>
            @endif
        </div>
    </form>

    @if($hasRoot)
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
                @foreach($users as $viewUser)
                <tr>
                    <td>
                      {{-- only let admins add people they are over to groups, they can't add themselves --}}
                      @if($user->id != $viewUser->id)
                        <!-- Trigger group add modal -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addGroup{{$viewUser->id}}">Add Group</button>
                      @endif
                    </td>
                    <td>
                        @if($hasRoot && $user->id != $viewUser->id)
                            <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#manageRole{{$viewUser->id}}">
                        @endif

                        @if($viewUser->role)
                            {{$viewUser->role->name}}
                        @else
                            User
                        @endif

                        @if($hasRoot)
                            </button>
                        @endif
                    </td>
                    <td>
                      @if(count($viewUser->semesters))
                          @foreach ($viewUser->semesters as $semester)
                            <span class="badge">
                              <a href="/admin?search=group:{{$semester->id}}">{{$semester->name}}</a>
                              <a href="admin/group/delete/{{$viewUser->id}}/{{$semester->id}}"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </span>
                          @endforeach
                      @else
                        <a href="/admin?search=group:0">&lt;none&gt;</a>
                      @endif
                    </td>
                    <td><a href="/monthly-tracking/{{$viewUser->id}}">{{$viewUser->first_name}}</a></td>
                    <td>{{$viewUser->last_name}}</td>
                    <td>
                        <div>{{$viewUser->email}}</div>
                        <div>{{$viewUser->external_id}}</div>
                    </td>
                    <td>
                        <div>{{$viewUser->created_at->diffForHumans()}}</div>
                        <small><div class="help-block">{{$viewUser->created_at->format('Y-m-d H:i T')}}</div></small>
                    </td>
                    {{-- <td>
                        <div class="form-group" @if($viewUser->graded_at) title="Grader: {{$viewUser->grader->name}} ({{$viewUser->graded_at}})" @endif>
                            <label>
                                <input type="radio" name="graded[{{$viewUser->id}}]" value="1" @if($viewUser->graded_at) checked @endif>
                                graded
                            </label> &nbsp;
                            <label>
                                <input type="radio" name="graded[{{$viewUser->id}}]" value="0" @if(!$viewUser->graded_at) checked @endif >
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

    @foreach ($users as $viewUser)
      <!-- Group Add Modal -->
      <div id="addGroup{{$viewUser->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Group</h4>
            </div>
            <div class="modal-body">
              <form class="" action="admin/group/add/user/{{$viewUser->id}}" method="post">
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

      @if($hasRoot)
        <!-- Role Manage Modal -->
        <div id="manageRole{{$viewUser->id}}" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Role</h4>
              </div>
              <div class="modal-body">
                <form class="" action="admin/user/role/{{$viewUser->id}}" method="post">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" name="role" id="role">
                        <option value="">User</option>
                        @foreach ($roles as $role)
                          <option value="{{$role->id}}" @if($role->id == $viewUser->role_id) selected @endif>{{$role->name}}</option>
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
