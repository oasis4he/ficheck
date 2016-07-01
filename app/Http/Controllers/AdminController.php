<?php

namespace App\Http\Controllers;

use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = '%'.$request->get('search').'%';

        $users = User::orWhere('name', 'LIKE', $search)
            ->orWhere('email', 'LIKE', $search)
            ->orWhere('external_id', 'LIKE', $search)
            ->orWhereHas('role', function ($query) use ($search) {
                $query->where('name', 'LIKE', $search);
            })
            ->orderBy('role_id', 'name', 'email')
            ->paginate();

        return view('admin.index', ['users' => $users]);
    }

    public function grade(Request $request)
    {
        $grader = Auth::user();

        $graded = $request->get('graded');

        foreach($graded as $userId=>$isGraded) {
            $user = User::findOrFail($userId);

            if($isGraded && !$user->graded_at) {
                $user->graded_by = $grader->id;
                $user->graded_at = Carbon::now();
            } elseif(!$isGraded && $user->graded_at) {
                $user->graded_by = null;
                $user->graded_at = null;
            }

            $user->save();
        }

        return redirect()->back();
    }
}
