<?php

use App\Models\User;
use App\Models\Week;
use App\Models\Batch;
use App\Models\Career;
use App\Models\Course;
use App\Models\CvForm;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Application;
use function App\Helper\hello;
use App\Models\CourseCompletion;
use App\Models\CoursePerStudent;
use function App\Helper\storeFile;
use App\Mail\AdminLoginVertifyMail;
use App\Utils\CheckToDeleteService;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
