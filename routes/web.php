<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\jabatanController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\profilUserControlller;
use App\Http\Controllers\riwayatTugasController;
use App\Http\Controllers\stafController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Organization;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::prefix('users')->group(function () {
    //route admin
    //route manajemen organisasi
    Route::resource('/organisasi', OrganizationController::class)->middleware('auth');
    Route::prefix('organisasi')->group(function(){
        Route::get('/jabatan/{id}',[jabatanController::class, 'show'])->middleware('auth');
        Route::post('/jabatan/store',[jabatanController::class, 'store'])->middleware('auth');
        Route::put('/jabatan/update/{id}',[jabatanController::class, 'update'])->middleware('auth');
        Route::delete('/jabatan/destroy/{id}',[jabatanController::class, 'destroy'])->middleware('auth');
    });
    Route::resource('/pegawai', UserController::class)->middleware('auth');
    Route::prefix('pegawai')->group(function(){
        Route::put('/update-profile/{id}', [PejabatController::class, 'update_user'])->name('update_user')->middleware('auth');
        //route memanggil jabatan berdasarkan id organisasi
        Route::get('/jabatan_user/{id}', [UserController::class,'getJabatan'])->middleware('auth');
    });

    Route::get('/', [DashboardController::class, 'index'])->name('beranda')->middleware('auth');
    Route::resource('profil', profilUserControlller::class)->middleware('auth');

    //route fitur task-duties
    Route::resource('/task-duties', PejabatController::class)->middleware('auth');
    Route::prefix('task-duties')->group(function(){
        Route::get('/filter-by-priority/index={id}', [PejabatController::class, 'get_task_by_priority'])->name('get-task-by-priority')->middleware('auth');
        Route::get('/filter-by-status/index={id}', [PejabatController::class, 'get_task_by_status'])->name('get-task-by-status')->middleware('auth');
        // url get jabatan & user untuk keperluan dropdown create & edit task
        Route::get('get-jabatan/{id}', [TaskController::class, 'getJabatan']);
        Route::get('get-user/{id}', [TaskController::class, 'getUser']);
        // route button accepted
        Route::put('/accepted/{id}', [stafController::class, 'accepted_task'])->name('accepted_task');
        // route button revisi
        Route::post('/revision', [stafController::class, 'revision_task'])->name('revision_task');
    });

    //route fitur my-task
    Route::resource('/my-task', stafController::class)->middleware('auth');
    Route::prefix('my-task')->group(function(){
        Route::get('/dashboard_staff', [stafController::class, 'dashboard_staff'])->name('dashboard_staff')->middleware('auth');
        Route::get('filter-by-status/index={id}', [stafController::class, 'filter_by_status'])->name('detail-where-staus')->middleware('auth');
        Route::get('filter-by-priority/index={id}', [stafController::class, 'filter_by_priority'])->name('detail-where-priority')->middleware('auth');
        Route::resource('/riwayat_tugas', riwayatTugasController::class)->middleware('auth');

        // route button pending
        Route::put('/pending_tugas/{id}', [stafController::class, 'pending_task'])->name('pending_tugas');
        // route button star working
        Route::put('/start_working/{id}', [stafController::class, 'start_working_task'])->name('start_working_task');

    });

});

//route authentication
Route::post('/login/store', [loginController::class, 'authenticate'])
    ->name('login')
    ->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/login', [loginController::class, 'index'])
    ->name('home')
    ->middleware('guest');

Route::resource('/user_pejabat/DetailTask', TaskController::class)->middleware('auth');
Route::get('/dashboard-chart', [TaskController::class, 'getTaskByPriority'])->name('getDataTaskbyStatus');

Route::get('/char', function(){
    return view('index');
});