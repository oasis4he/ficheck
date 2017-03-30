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
        $search = $request->get('search');
        $usersQuery = User::orWhere('first_name', 'LIKE', '%'.trim($search).'%')
            ->orWhere('last_name', 'LIKE', '%'.trim($search).'%')
            ->orWhere('email', 'LIKE', '%'.trim($search).'%');

        // allow space separated, comma or semicolon separated items to be searched on (external_id)
        $fixedSearch = preg_replace('/[\s,;]+/', ',', $search);

        foreach(explode(",", $fixedSearch) as $searchTerm) {
            $usersQuery = $usersQuery->orWhere('external_id', 'LIKE', '%'.trim($searchTerm).'%');
        }

        $usersQuery = $usersQuery
            ->orWhereHas('role', function ($query) use ($search) {
                $query->where('name', 'LIKE', $search);
            })
            ->orderBy('role_id', 'desc')->orderBy('first_name')->orderBy('email');

        $users = $usersQuery->paginate();

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
