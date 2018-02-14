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
                    <th scope="row">ID</th>
                    <th scope="row">Name</th>
                    <th scope="row">Slug</th>
                    <th scope="row">Members</th>
                    <th scope="row">Created</th>
                    <th scope="row">Updated</th>
            </thead>
            <tbody>
                @foreach($groups as $i=>$group)
                <tr @if($i == 0 && $page == 1 && $search == '') style="background: #ffe;"@endif>
                    <th scope="row" class="text-center">
                        {{$group->id}}
                        @if($i == 0 && $page == 1 && $search == '')
                            <div class="text-muted small">
                                &lt;DEFAULT&gt;
                            </div>
                        @endif
                    </th>
                    <td>
                        <input type="text" class="form-control" name="group[{{$group->id}}][name]" value="{{old('group['.$group->id.'][name]', $group->name)}}" id="group_{{$group->id}}_name" placeholder="Group Name">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="group[{{$group->id}}][slug]" value="{{old('group['.$group->id.'][slug]', $group->slug)}}" id="group_{{$group->id}}_slug" placeholder="slug">
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
                        <input type="text" class="form-control" name="new_slug" value="{{old('new_slug')}}" id="new_slug" placeholder="slug">
                    </td>
                    <td colspan="3">
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
