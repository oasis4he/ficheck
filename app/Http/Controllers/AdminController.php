<?php

namespace App\Http\Controllers;

use App\User;
use App\Semester;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $groups = $user->semesters()->pluck('semester_id')->toArray();

        $search = $request->get('search');
        $usersQuery = User::where(function($query) use ($search){
          $query->where('first_name', 'LIKE', '%'.trim($search).'%');
          $query->orWhere('last_name', 'LIKE', '%'.trim($search).'%');
          $query->orWhere('email', 'LIKE', '%'.trim($search).'%');

          // allow space separated, comma or semicolon separated items to be searched on (external_id)
          $fixedSearch = preg_replace('/[\s,;]+/', ',', $search);

          foreach(explode(",", $fixedSearch) as $searchTerm) {
            $query->orWhere('external_id', 'LIKE', '%'.trim($searchTerm).'%');
          }

          $query->orWhereHas('role', function ($query) use ($search) {
              $query->where('name', 'LIKE', $search);
          });
        });

        if($groups){
          $usersQuery = $usersQuery->whereHas('semesters', function($query) use ($groups){
            $query->whereIn('semester_id', $groups);
          });
        }

        $usersQuery= $usersQuery->orderBy('role_id', 'desc')->orderBy('first_name')->orderBy('email');

        $users = $usersQuery->paginate();
        $semesters = Semester::all();

        return view('admin.index', ['users' => $users, 'semesters' => $semesters]);
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

    public function addGroupUser(Request $request, $id)
    {
      $user = User::findOrFail($id);
      $semesterID = $request->get('semester');
      $hasSemester = $user->semesters()->where('semester_id', $semesterID)->exists();

      if(!$hasSemester) {
        $user->semesters()->attach($semesterID);
      }

      return redirect()->back();
    }

    public function deleteGroupUser($userID, $semesterID)
    {
      $user = User::findOrFail($userID);
      $hasSemester = $user->semesters()->where('semester_id', $semesterID)->exists();

      if($hasSemester) {
        $user->semesters()->detach($semesterID);
      }

      return redirect()->back();
    }
}
