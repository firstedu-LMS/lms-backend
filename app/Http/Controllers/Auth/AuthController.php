<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\BaseController;

class AuthController extends BaseController
{
    public function createStudentId()
    {
        $student = Student::select('student_id')
            ->orderByDesc('student_id')
            ->value('student_id');
        $studentIdOnly = substr($student, 2);
        if ($studentIdOnly) {
            $studentId = str_pad((int)$studentIdOnly + 1, 4, "0", STR_PAD_LEFT);
        } else {
            $studentId = config('student.id');
        }
        return "S-" . $studentId;
    }

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
        if ($request->role) {
            $user->assignRole($request->role);
        } else {
            $user->assignRole('student');
            $student = new Student();
            $student->student_id = $this->createStudentId();
            $student->user_id = $user->id;
            $student->save();
        }
        $user = User::where('id', $user->id)->with('image')->first();
        $token = $user->createToken("first-lms")->plainTextToken;

        return $this->success(["user" => $user, "token" => $token], "Created", config('http_status_code.created'));
    }

    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->with('roles')->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // event(new Registered($user));
                $token = $user->createToken("first-lms")->plainTextToken;
                if ($user->image_id !== null) {
                    $user = User::where('email', $request->email)->with(['image', 'roles'])->first();
                }
                return $this->success([
                    "user" => $user,
                    "token" => $token
                ], 'login');
            } else {
                return $this->error(["password" => "Wrong Password !"], "", config('http_status_code.forbidden'));
            }
        } else {
            return $this->error(["email" => "There is no user with this email !"], "", config('http_status_code.forbidden'));
        }
    }


    public function logout(Request $request)
    {
        $user = auth('sanctum')->user();
        $request->user()->currentAccessToken()->delete();
        return $this->success($user, 'Logout');
    }
}
