@extends('layouts.app')

@section('content')
<table class="table striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>A-Number</th>
            <th>Graded</th>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td><a href="/monthly-tracking/{{$user->id}}">{{$user->name}}</a></td>
            <td>{{$user->email}}</td>
            <td>{{$user->external_id}}</td>
            <td>{{$user->graded_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
