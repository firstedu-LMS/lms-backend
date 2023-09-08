<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        return Student::where('id', $user->id)->with(['roles','image'])->first();
    }
}
