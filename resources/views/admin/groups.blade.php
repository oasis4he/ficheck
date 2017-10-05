@extends('layouts.app')

@section('content')

<div class="row">
    <form method="get" class="search col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Group" name="search" value="{{Request::get('search')}}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit" aria-label="Search"><i class="glyphicon glyphicon-search"></i></button>
            </span>
        </div>
        @if(Request::get('search'))
            <a href="/admin/groups">clear search</a>
        @endif
    </form>

    @if(Auth::user()->hasRole('root'))
        <div class="col-md-6 text-right">
            <a class="btn btn-default" href="/admin">Users</a>
        </div>
    @endif
</div>
<hr>
<div class="row">
    <form method="post" action="/admin/groups">
        {!! csrf_field() !!}

        @include('partials.form-errors')

        <table class="table striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Members</th>
                    <th>Created</th>
                    <th>Updated</th>
            </thead>
            <tbody>
                @foreach($groups as $group)
                <tr>
                    <td>
                        {{$group->id}}
                    </td>
                    <td>
                        <input type="text" class="form-control" name="group[{{$group->id}}][name]" value="{{old('group['.$group->id.'][name]', $group->name)}}" id="group_{{$group->id}}_name" placeholder="Group Name">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="group[{{$group->id}}][description]" value="{{old('group['.$group->id.'][description]', $group->description)}}" id="group_{{$group->id}}_description" placeholder="Description">
                    </td>
                    <td>
                      <a href="/admin?search=group:{{$group->id}}">
                          {{$group->users->count()}}
                      </a>
                    </td>
                    <td>
                        {{$group->created_at->diffForHumans()}}
                    </td>
                    <td>
                        {{$group->updated_at->diffForHumans()}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>

                    </td>
                    <td>
                        <input type="text" class="form-control" name="new_group" value="{{old('new_group')}}" id="new_group" placeholder="Create new group">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="new_description" value="{{old('new_description')}}" id="new_description" placeholder="Description">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>

        <button class="btn btn-primary pull-right">Save</button>
    </form>
</div>
<div class="text-center">
    {!! $groups->render() !!}
</div>
@stop
