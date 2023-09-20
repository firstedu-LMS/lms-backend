<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Instructor;
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
Route::get('/', function () {
    $numberOfInstructors = 5;
    for ($i = 0; $i < $numberOfInstructors; $i++) {
        $instructor = Instructor::select('instructor_id')
            ->orderByDesc('instructor_id')
            ->value('instructor_id');
        $instructorIdOnly = substr($instructor, 2);
        if ($instructorIdOnly) {
             $instructorId = "I-" . str_pad((int)$instructorIdOnly + 1, 4, "0", STR_PAD_LEFT);
        } else {
            $instructorId = "I" . config('instructorid.id');
        }
        $user = new User();
        $user->name = fake()->name();
        $user->email = fake()->unique()->safeEmail();
        $user->password = Hash::make('internet');
        $user->save();
        $instructor = new Instructor();
        $instructor->user_id = $user->id;
        $instructor->instructor_id = $instructorId;
        $instructor->cv_id = 1;
        $instructor->save();
    }
    return "Finish";
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


Route::get('/create-admin',function(){
    User::create([
        'name' => 'admin',
        'email' => "admin@gmail.com",
        'password' =>Hash::make('internet'),
    ]);
    $admin = User::where('email','admin@gmail.com')->first();
    $admin->assignRole('admin');
    return $admin;
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json([
        'data' => 'oki'
    ]);
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::get('delete-service',function ()  {
    $clean = new CheckToDeleteService( 'Course' , 2);
    $clean->naruto()->isClean();
});