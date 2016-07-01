@extends('layouts.app')

@section('content')

<div class="row">
    <form method="get" class="search col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Name, email, A-Number, Role" name="search" value="{{Request::get('search')}}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" aria-label="Search"><i class="glyphicon glyphicon-search"></i></button>
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
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>A-Number</th>
                    <th>Graded</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        @if($user->role)
                            {{$user->role->name}}
                        @endif
                    </td>
                    <td><a href="/monthly-tracking/{{$user->id}}">{{$user->name}}</a></td>
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
</div>
<div class="text-center">
    {!! $users->render() !!}
</div>
@stop
