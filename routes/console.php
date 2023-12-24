<?php

use Carbon\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:create-roles', function() {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'instructor']);
    Role::create(['name' => 'student']);
});
Artisan::command('app:create-admin', function() {
    $admin = new User();
    $admin->name = 'admin';
    $admin->email = 'admin@gmail.com';
    $admin->password = Hash::make('internet');
    $admin->save();
    $admin->assignRole('admin');
});
