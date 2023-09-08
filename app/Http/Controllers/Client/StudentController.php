<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends BaseController
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $student = Student::where('id', $user->id)->with(['user' => function ($query) {
            $query->with(['image','roles']);
        }])->first();
        return $this->success($student, 'student info');
    }

    public function update(Request $request, $student)
    {
        $student = Student::where('id', $student)->first();
        foreach ($request->all() as $key => $value) {
            $student->$key = $value;
        }
        $student->update();
        return $this->success($student, "student info updated");
    }
}
