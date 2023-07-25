<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{


    public function register(AuthRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->image_id) {
            $user->image_id = $request->image_id;
        }
        $user->save();
        if ($request->role === "admin") {
            $user->assignRole('admin');
        } else if ($request->role === "instructor") {
            $user->assignRole('insrructor');
        } else {
            $user->assignRole('user');
        }
        $token = $user->createToken("first-lms")->plainTextToken;
        $user = User::where('id', $user->id)->with('image')->first();
        return $this->success(["user" => $user, "token" => $token], "Created", config('http_status_code.created'));
    }

    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("first-lms")->plainTextToken;
                if ($user->image_id !== null) {
                    $user = User::where('email', $request->email)->with('image')->first();
                }
                return $this->success([
                    "user" => $user,
                    "token" => $token
                ], 'login');
            } else {
                return $this->error([], "Wrong Password !",config('http_status_code.forbidden'));
            }
        } else {
            return $this->error([], "There is no user with this email !",config('http_status_code.not_found'));
        }
    }


    public function logout(Request $request){
        $user = auth('sanctum')->user();
        $user->currentAccessToken()->delete();
        return $this->success($user, 'Logout');
    }
}
