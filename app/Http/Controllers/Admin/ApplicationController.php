<?php

namespace App\Http\Controllers\Admin;

use App\Mail\InformInstructorMail;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\InstructorRequest;
use App\Http\Resources\ApplicationResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends BaseController
{
    public function index()
    {
        return $this->success(ApplicationResource::collection(Application::with('cv')->get()), 'All applications');
    }

    public function store(ApplicationRequest $request)
    {
        $application = new Application();
        $application->career = $request->career;
        $application->email = $request->email;
        $application->cv_id = $request->cv_id;
        $application->save();
        return $this->success(new ApplicationResource($application), 'Created', config('http_status_code.created'));
    }

    public function destroy(string $id)
    {
        $application = Application::where('id', $id)->first();
        if (!$application) {
            return $this->error([], "application not found", config('http_status_code.not_found'));
        }
        $application->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }

    public function createInstructorId()
    {
        $instructor = Instructor::select('instructor_id')
            ->orderByDesc('instructor_id')
            ->value('instructor_id');
            $instructorIdOnly = substr($instructor, 2);
        if ($instructorIdOnly) {
            $instructorId = str_pad((int)$instructorIdOnly + 1, 4, "0", STR_PAD_LEFT);
        } else {
            $instructorId = config('instructorid.id');
        }
        return "I-" . $instructorId;
    }

    public function removedApplication($email)
    {
        $application = Application::where('email', $email)->first();
        $application->delete();
    }

    public function addInstructor(InstructorRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password) ;
        $user->save();
        $instructor = new Instructor();
        $instructor->instructor_id = $this->createInstructorId();
        $instructor->user_id = $user->id;
        $instructor->cv_id = $request->cv_id;
        $instructor->save();
        //Mail::to($user->email)->send(new InformInstructorMail($request->email, $request->password));
        $this->removedApplication($user->email);
        return $this->success($instructor, 'Created', config('http_status_code.created'));
    }
}
