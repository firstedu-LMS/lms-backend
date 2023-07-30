<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AddInstructorController extends Controller
{
    public function store(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        $filename = time() . "_" . $request->file('cv')->getclientoriginalname();
        $filestore =  request()->file('file')->storeas('cvform', $filename);
   }
}
