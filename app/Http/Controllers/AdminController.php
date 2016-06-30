<?php

namespace App\Http\Controllers;

use App\User;

use App\Http\Requests;

use Illuminate\Http\Request;


class AdminController extends Controller
{
    function index() {
        $users = User::paginate();

        return view('admin.index', ['users'=>$users]);
    }
}
