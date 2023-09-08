<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function show($student)
    {
        return User::where('id', $student)->with(['roles','image','student'])->first();
    }
}
