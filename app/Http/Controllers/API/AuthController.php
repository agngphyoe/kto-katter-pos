<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Actions\StoreActivityLog;
use App\Exceptions\StaffNotExists;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Staff\UpdateRequest;
use App\Http\Requests\API\Staff\UpdateStaffInfoRequest;
use App\Http\Requests\API\Staff\UpdateStaffPasswordRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HandlerResponse;

    public function login(LoginRequest $request)
    {
        $staff = User::whereName($request->name)
                    ->where('role_id', 2)
                    ->first();

        if (!$staff) {
            throw new StaffNotExists();
        }
              
        if (!strpos($staff->role?->name, "Van Sales") === false) {
            return $this->responseUnauthorized(
                message: 'Wrong user.',
                status_code: 403
            );
        }

        if (!Hash::check($request->password, $staff->password)) {
            return $this->responseUnauthorized(
                message: 'Password incorrect.',
                status_code: Response::HTTP_UNAUTHORIZED
            );
        }
       
        // Revoke existing tokens if user is already logged in
        if ($staff->tokens->count() > 0) {

            $staff->tokens->each->delete();
        }

        $token = $staff->createToken($staff->name)->accessToken;

        return response()->json([
            'token' => $token,
            'user' => new StaffResource($staff),
            'message' => 'User Login Successfully.',
            'status' => 200,
        ], 200);
    }

    public function profile()
    {
        return response()->json([
            'user' => new StaffResource(auth()->user()),
            'message' => 'Successfully',
            'status' => 200,
        ], 200);
    }

    public function changeInfo(UpdateStaffInfoRequest $request)
    {
        $staff = User::find(auth()->user()->id);

        if (!$staff) {

            throw new StaffNotExists();
        }

        $staff->update([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        return $this->responseSuccess(new StaffResource($staff), 200, 'Info Updated Successfully.');
    }

    public function changePassword(UpdateStaffPasswordRequest $request)
    {
        $old_password       = $request->old_password;
        $new_password       = $request->new_password;

        $staff = User::find(auth()->user()->id);

        if (!$staff) {

            throw new StaffNotExists();
        }

        if (!Hash::check($old_password, $staff->password)) {

            return $this->responseUnauthorized(message: 'Password Incorrect.', status_code: Response::HTTP_UNAUTHORIZED);
        }

        $staff->update(['password' => Hash::make($new_password)]);

        // StoreActivityLog::store($staff, title: 'Staff Change Password', activity: 'Update');

        return $this->responseSuccessMessage(message: 'Password Changed Successfully.');
    }

    public function logout()
    {
        
        Auth::user()->tokens->each->delete();

        return $this->responseSuccessMessage(message: 'Successfully logged out');
    }
}
