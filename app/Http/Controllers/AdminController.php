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
        $hasRoot = $user->hasRole('root');
        $groups = $user->semesters()->get();

        $globalUser = false;

        if(count($groups) == 0) {
            $globalUser = true;
            $groups = Semester::orderBy('name')->get();
        }

        $search = $request->get('search');
        $page = $request->query('page', 1);
        $groupFilter = $request->query('group');

        $usersQuery = User::where(function($query) use ($search){
            if($search) {
                $query->where('first_name', 'LIKE', '%'.trim($search).'%');
                $query->orWhere('last_name', 'LIKE', '%'.trim($search).'%');
                $query->orWhere('email', 'LIKE', '%'.trim($search).'%');

                // allow space separated, comma or semicolon separated items to be searched on (external_id)
                $fixedSearch = preg_replace('/[\s,;]+/', ',', $search);

                foreach(explode(",", $fixedSearch) as $searchTerm) {
                    $query->orWhere('external_id', 'LIKE', '%'.trim($searchTerm).'%');

                    if(preg_match('/^group\:\d+/', $searchTerm)) {
                        $groupId = explode(':', $searchTerm)[1];

                        if($groupId != 0) {
                            $query->orWhereHas('semesters', function ($query) use ($groupId) {
                                $query->where('semesters.id', $groupId);
                            });
                        } else {
                            $query->orWhere(function($query) use ($groupId) {
                                $query->whereDoesntHave('semesters');
                            });
                        }
                    }
                }

                $query->orWhereHas('role', function ($query) use ($search) {
                    $query->where('name', 'LIKE', $search);
                });
            }
        });


        // limit view to groups the user has access to if they aren't a global user
        if(!$globalUser){
          $usersQuery = $usersQuery->whereHas('semesters', function($query) use ($groups){
            $query->whereIn('semester_id', $groups->pluck('semester_id')->toArray());
          });
        }

        if($groupFilter) {
            $usersQuery->whereHas('semesters', function ($query) use ($groupFilter) {
                $query->where('semesters.slug', $groupFilter);
            });
        }

        $sort = $request->query('sort');
        $sortDirection = $request->query('direction', '1');

        $sortColumns = [
            'storeID',
            'first_name',
            'last_name',
            'email',
            'created_at'
        ];

        $sortColumn = in_array($sort, $sortColumns) ? $sort : null;

        $sortAscending = 1;
        $sortDescending = -1;


        if($sortDirection == $sortAscending){
            $sortDir = 'ASC';
        } else {
            $sortDir = 'DESC';
        }

        $usersQuery->when($sortColumn, function($query) use ($sortColumn, $sortDir) {
            $query->orderBy($sortColumn, $sortDir);
        },
        function($query) {
            $query->orderBy('role_id', 'desc')->orderBy('first_name')->orderBy('email');
        });

        $users = $usersQuery->paginate();
        $semesters = Semester::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        return view('admin.index', [
            'users' => $users,
            'user' => $user,
            'hasRoot' => $hasRoot,
            'semesters' => $semesters,
            'groups' => $groups,
            'groupFilter' => $groupFilter,
            'roles' => $roles,
            'sort' => $sort,
            'sortDirection' => $sortDirection,
            'page' => $page,
            'search' => $search,
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
        $groupsQuery = Semester::orderBy('id', 'desc');
        $page = $request->get('page', 1);

        $search = $request->get('search');
        $groupsQuery->where(function($query) use ($search){
          $query->where('name', 'LIKE', '%'.trim($search).'%');

          // allow space separated, comma or semicolon separated items to be searched on (external_id)
          $fixedSearch = preg_replace('/[\s,;]+/', ',', $search);

          foreach(explode(",", $fixedSearch) as $searchTerm) {
            $query->orWhere('id', 'LIKE', '%'.trim($searchTerm).'%');
            $query->orWhere('slug', 'LIKE', '%'.trim($searchTerm).'%');
          }
        });

        $groups = $groupsQuery->with('users')->paginate();

        return view('admin.groups', ['groups' => $groups, 'page' => $page, 'search' => $search]);
    }

    public function saveGroups(Request $request)
    {
        $errors = [];

        if($request->has('new_group')) {
            $newGroup = new Semester();
            $newGroup->name = $request->input('new_group');
            $newGroup->slug = $request->input('new_slug');

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
                    $group->slug = $groupData['slug'];

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

      if(!$user->role_id){
        $user->role_id = null;
      }

      $user->save();

      return redirect()->back();
    }
}
