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
//This route will generate 5
Route::get('/{id}', function ($student) {
    $coursePerStudents = CoursePerStudent::where('student_id', $student)->with(['batch' => function ($query) {
        $query->with(['course' => function ($query) {
            $query->with('image');
        }]);
    }, 'student'])->get();

    $data = $coursePerStudents->map(function ($coursePerStudents) {
        $courseCompletion = CourseCompletion::where('student_id', $coursePerStudents->student_id)->where('course_id', $coursePerStudents->course_id)->first();
        $percentage = ($courseCompletion->week_completion_count / $courseCompletion->week_count) * 100;
        $coursePerStudents['percentage'] =  substr((int)$percentage, 0, 2) . "%";
        return $coursePerStudents;
    });

    return $data;
});
Route::get('/fakeDatas', function () {
    Application::factory()->count(5)->create();
    Batch::factory()->count(5)->create();
    Career::factory()->count(5)->create();
    CvForm::factory()->count(5)->create();
    Course::factory()->count(5)->create();
    Instructor::factory()->count(10)->create();
    Student::factory()->count(20)->create();
    Week::factory()->count(15)->create();
    Enrollment::factory()->count(30)->create();
    Assignment::factory()->count(10)->create();
    return response('
        <div style="display:flex;justify-content:center;align-items:center;width:100vw;height:100vh;">
        <span style="color:cornflowerblue; font-size: 100px;">Suii</span></div>
    ');
});
Route::get('/mail', function () {
    Mail::to('myatkyawt974@gmail.com')->send(new AdminLoginVertifyMail());
    echo "mail sended";
});

Route::get('/sql', function () {
    $instructors =  Instructor::all();
    echo  $instructors;
    $i = 0;
    $arryLength = count($instructors);
    foreach ($instructors as $index => $instructor) {
        $i = $index;
        $data = json_decode($instructor, true);
        $tableName = "instructors";
        $columns = "`" . implode("`, `", array_keys($data)) . "`";
        $values = [];
        foreach ($data as $value) {
            if ($value === null) {
                $values[] = "NULL";
            } else {
                $values[] = "'" . $value . "'";
            }
        }
        $valuesString = implode(", ", $values);
        $filePath =  base_path('app') . DIRECTORY_SEPARATOR . "backup" . DIRECTORY_SEPARATOR . "backup.sql";
        $dir =  base_path('app') . DIRECTORY_SEPARATOR . "backup";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($filePath)) {
            $header  = "INSERT INTO `$tableName` ($columns) VALUES\n";
            file_put_contents($filePath, $header, FILE_APPEND);
        }
        if ($i == $arryLength - 1) {
            $sql = "  ($valuesString);" . "\n";
        } else {
            $sql = "  ($valuesString)," . "\n";
        }
        file_put_contents($filePath, $sql, FILE_APPEND);
    }
});


Route::get('/create-admin', function () {
    User::create([
        'name' => 'admin',
        'email' => "admin@gmail.com",
        'password' => Hash::make('internet'),
    ]);
    $admin = User::where('email', 'admin@gmail.com')->first();
    $admin->assignRole('admin');
    return $admin;
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json([
        'data' => 'oki'
    ]);
})->middleware(['auth', 'signed'])->name('verification.verify');



// Route::get('something/{something}',function ($something)  {

//     $coursePerStudents = CoursePerStudent::where('student_id', $something)->with(['batch' => function ($query) {
//         $query->with(['course' => function ($query) {
//             $query->with('image');
//         }]);
//     }, 'student'])->get();

//     $data = $coursePerStudents->map(function ($coursePerStudents) {
//         $course_completion = CourseCompletion::where('student_id',$coursePerStudents->student_id)->where('course_id'.$coursePerStudents->course_id)->frist();
//         $weekCout = $course_completion->week_count;
//         $week_completion_count = $course_completion->course_completion_count;
//         $coursePerStudents->percentage = $weekCout / $week_completion_count * 100;
//         return $coursePerStudents;
//     });

//     return $data;
// });