<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\ImageStoreInPublic;
use App\Actions\StoreActivityLog;
use App\Constants\PrefixCodeID;
use App\Http\Requests\User\FirstFormEditRequest;
use App\Http\Requests\User\FirstFormStoreRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequestFormOneFromProfile;
use App\Http\Requests\User\UpdateRequestFromProfile;
use App\Http\Requests\User\UpdateRequestFromProfileUpdate;
use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(10);
        $total_count    = User::count();
        $activies       = ActivityLog::take(5)->get();

        $permission_count   = Permission::count();

        return view('user.index', compact('users', 'permission_count', 'total_count', 'activies'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $query        = User::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeUserFilter(query: $query);

            $users = $query->paginate(10);
            $permission_count   = Permission::count();
            $html = View::make('user.search', compact('users', 'permission_count'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $users))->pagination()
            ]);
        }

        $users = User::orderByDesc('id')->paginate(10);
        $total_count    = User::count();
        $permission_count   = Permission::count();
        return view('user.list', compact('users', 'permission_count', 'total_count'));
    }

    public function activityList(Request $request)
    {
        if ($request->ajax()) {

            $query        = ActivityLog::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeUserActivityFilter(query: $query);

            $activies = $query->paginate(10);

            $html = View::make('user.activity-search', compact('activies'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $activies))->pagination()
            ]);
        }

        $activies = ActivityLog::orderByDesc('id')->paginate(10);
        $total_count    = ActivityLog::count();
        return view('user.activity-list', compact('activies', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function createFirst()
    {
        $roles = Role::all();

        $exist_record = User::latest()->first();

        $companies = Company::all();

        $locations = Location::all();

        $user_number = getAutoGenerateID(PrefixCodeID::ADMIN, $exist_record?->user_number);

        return view('user.create-first', compact('roles', 'user_number', 'companies', 'locations'));
    }

    public function createFinal(FirstFormStoreRequest $request)
    {
        $role = Role::find($request->role_id);
        $data = $request->only(['name', 'phone', 'email', 'password', 'nrc', 'user_number', 'location_id']);
        $permission_groups = PermissionGroup::all();
        $locations = Location::find($request->location_id);
        $image = $request->image ? (new ImageStoreInPublic())->storePublic(destination: 'users/image', image: $request->image) : null;
        return view('user.create-final', compact('data', 'role', 'permission_groups', 'locations', 'image'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeFinal(StoreRequest $request)
    {
        $data = [];
        $locations = $request->location_id;

        $data['name'] = $request->name;
        $data['role_id'] = $request->role_id;
        $data['password'] = Hash::make($request->password);
        $data['slug'] = Str::slug($request->name);
        $data['created_by'] = Auth::user()->id;
        $data['phone'] = $request->phone;
        $data['user_number'] = $request->user_number;
        $data['image'] = $request->image ?? NULL;

        $permissions = $request->permissions;

        $request = $request->all();

        DB::beginTransaction();
        try {

            $user = User::create($data);
            foreach ($locations as $location) {
                DB::table('user_location')->insert([
                    'user_id' => (int)$user->id,
                    'location_id' => (int)$location
                ]);
            }

            $user->permissions()->sync($permissions);

            if ($user) {
                StoreActivityLog::store(model: $user, title: 'User Account Created', activity: 'Create');
            }

            DB::commit();

            return redirect()->route('user')->with('success', 'Success! User Created.');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return redirect()->route('user')->with('error', 'Failed! User can not Created');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $groups  = PermissionGroup::all();
        return view('user.detail', compact('groups', 'user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTask(User $user)
    {
        return view('user.user-task', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editFirst(User $user)
    {
        $roles = Role::all();
        $companies = Company::all();
        $locations = Location::all();

        return view('user.edit-first', compact('user', 'roles', 'companies', 'locations'));
    }

    public function editFinal(Request $request)
    {
        $role = Role::find($request->role_id);
        $data = $request->only(['name', 'phone', 'email', 'password', 'nrc', 'image', 'location_id']);
        $user = User::find($request->user_id);
        $permission_groups = PermissionGroup::all();
        $extra_permissions = $user->permissions()->pluck('permissions.id')->toArray();
        $locations = Location::find($request->location_id);
        $image = $request->image ? (new ImageStoreInPublic())->storePublic(destination: 'users/image', image: $request->image) : null;

        return view('user.edit-final', compact('data', 'role', 'permission_groups', 'extra_permissions', 'user', 'locations', 'image'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $locations = $request->location_id;

        $permissions = $request->permissions;

        $data['password'] = $request->password ? Hash::make($request->password) : $user->password;
        $data['name'] = $request->name;
        $data['role_id'] = $request->role_id;
        $data['slug'] = Str::slug($request->name);
        $data['created_by'] = Auth::user()->id;
        $data['nrc'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['image'] = $request->image;

        DB::beginTransaction();
        try {
            $user->update($data);

            if ($locations) {
                DB::table('user_location')->where('user_id', $user->id)->delete();
                foreach ($locations as $location) {
                    DB::table('user_location')->insert([
                        'user_id' => (int)$user->id,
                        'location_id' => (int)$location
                    ]);
                }
            }

            StoreActivityLog::store($user, title: 'User Account Updated', activity: 'Update');
            $user = $user->permissions()->sync($permissions);

            DB::commit();

            return redirect()->route('user')->with('success', 'Success! User Created.');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return redirect()->route('user-create-final')->with('error', 'Failed! Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!($user->id == auth()->user()->id)) {
            $log = ActivityLog::where('createable_id', $user->id)->first();

            if ($log) {
                return response()->json([
                    'message' => 'Sorry, you cannot delete this record.',
                    'status' => 500,
                ], 500);
            } else {
                $user->delete();

                StoreActivityLog::store($user, title: 'User Account Deleted', activity: 'Delete');

                return response()->json([
                    'message' => 'The record has been deleted successfully.',
                    'status' => 200,
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Something went wrong.',
            'status' => 500,
        ], 500);
    }

    public function activate($id)
    {
        $user = User::find($id);

        $user->status = 1;
        $user->save();

        StoreActivityLog::store($user, title: 'User Account Activated', activity: 'Activated');

        return response()->json([
            'message' => 'Account activate is success.',
            'status' => 200,
        ], 200);
    }

    public function deactivate($id)
    {
        $user = User::find($id);

        $user->status = 0;
        $user->save();

        StoreActivityLog::store($user, title: 'User Account Deactivated', activity: 'Deactivated');

        return response()->json([
            'message' => 'Account deactivate is success.',
            'status' => 200,
        ], 200);
    }

    public function userSetting()
    {
        return view('user.setting');
    }

    public function checkPassForUserEdit(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required',
        ]);
        $password = $validatedData['password'];
        $stored_password = Auth::user()->password;

        if (Hash::check($password, $stored_password)) {
            return response()->json([
                'message' => 'Password verification successful.',
                'status' => 200,
            ], 200);
        }

        return response()->json([
            'message' => 'Password doesn\'t match.',
            'status' => 500,
        ], 500);
    }

    public function updateUserFormOneFromProfile(UpdateRequestFormOneFromProfile $request, User $user)
    {
        $request = $request->all();

        $user->update($request);

        if ($user) {
            return redirect()->route('user');
        }

        return redirect()->route('user');
    }

    public function updateUserFromProfile(UpdateRequestFromProfile $request, User $user)
    {
        $request['password'] = $request->password ? Hash::make($request->password) : Auth::user()->password;
        $request = $request->all();

        $user->update($request);

        if ($user) {
            return redirect()->route('user')->with('success', 'Your Account is Updated. ');
        }

        return redirect()->route('user');
    }

    public function resetNotiCount()
    {
        $user = auth()->user();
        $user->noti_unread_count = 0;
        $user->update();

        return response()->json([
            'message' => 'Notification count updated successfully'
        ], 200);
    }
}
