<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Semester;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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

            if(preg_match('/^group\:\d+/', $searchTerm)) {
                $query->orWhereHas('semesters', function ($query) use ($searchTerm) {
                    $groupId = explode(':', $searchTerm)[1];
                    $query->where('semesters.id', $groupId);
                });
            }
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
        $semesters = Semester::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        return view('admin.index', [
            'users' => $users,
            'semesters' => $semesters,
            'roles' => $roles
        ]);
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

    public function groups(Request $request)
    {
        $groupsQuery = Semester::orderBy('name');

        $search = $request->get('search');
        $groupsQuery->where(function($query) use ($search){
          $query->where('name', 'LIKE', '%'.trim($search).'%');

          // allow space separated, comma or semicolon separated items to be searched on (external_id)
          $fixedSearch = preg_replace('/[\s,;]+/', ',', $search);

          foreach(explode(",", $fixedSearch) as $searchTerm) {
            $query->orWhere('id', 'LIKE', '%'.trim($searchTerm).'%');
          }
        });

        $groups = $groupsQuery->with('users')->paginate();

        return view('admin.groups', ['groups' => $groups]);
    }

    public function saveGroups(Request $request)
    {
        $errors = [];

        if($request->has('new_group')) {
            $newGroup = new Semester();
            $newGroup->name = $request->input('new_group');
            $newGroup->description = $request->input('new_description');

            $newGroup->save();
        }

        if($request->has('group')) {
            foreach($request->input('group') as $groupId => $groupData) {
                $group = Semester::findOrFail($groupId);

                if($groupData['name'] == '') {
                    try {
                        $group->delete();
                    } catch(QueryException $e) {
                        if($e->getCode() == 23000) {
                            $errors[] = "Can't delete the group ".$group->name.". Remove all members from the group to delete it.";
                        }
                    }
                } else {
                    $group->name = $groupData['name'];
                    $group->description = $groupData['description'];

                    $group->save();
                }
            }
        }

        return \Redirect::back()->withErrors($errors);;
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

    public function saveRole(Request $request, $userID)
    {
      $user = User::findOrFail($userID);

      $user->role_id = $request->input('role');
      $user->save();

      return redirect()->back();
    }
}
