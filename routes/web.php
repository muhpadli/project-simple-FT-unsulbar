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

Route::get('/user-pimpinan/{id}', [PejabatController::class, 'draft_jabatan'])->name('viewJabatan')->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->name('beranda')->middleware('auth');

Route::get('/admin-beranda', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/organisasi', [DashboardController::class, 'organisasi'])->name('organisasi')->middleware('auth');

Route::get('/manageOrganization', function () {
    return view('layout.Admin.ManageOrganisasi');
});

Route::get('/homeAdmin', function () {
    return view('layout.DashboardAdmin');
});

Route::get('/here', function(){
    return view('layout.Staf.index_');
});

Route::get('page' , function(){
    return view('layout.landingpage');
});

Route::resource('/organisasi/add-jabatan', jabatanController::class)->middleware('auth');
Route::resource('/ManageUsers', UserController::class)->middleware('auth');
Route::resource('/manageOrganization', OrganizationController::class)->middleware('auth');
Route::get('/home', [loginController::class, 'index'])->name('home')->middleware('guest');
Route::post('/login', [loginController::class, 'authenticate'])->name('login')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::get('/profil_user
/{id}', [UserController::class, 'profil'])->name('profil_user')->middleware('auth');

Route::get('/dashboard-pimpinan/list-task-by-priority/{id}',[PejabatController::class, 'get_task_by_priority'])->name('get-task-by-priority')->middleware('auth');
Route::get('/dashboard-pimpinan/list-task-by-status/{id}',[PejabatController::class, 'get_task_by_status'])->name('get-task-by-status')->middleware('auth');
Route::get('/dashboard-pimpinan',[ PejabatController::class, 'beranda'])->name('dashoard-pimpinan')->middleware('auth');
Route::resource('/dashboard_pejabat', PejabatController::class)->middleware('auth');
Route::resource('/user_pejabat/DetailTask',TaskController::class)->middleware('auth');
Route::put('/user_pejabat/DetailTask/edit/{id}', [PejabatController::class, 'update_user'])->name('update_user')->middleware('auth');


Route::get('/user_staf/detail-tugas',[stafController::class, 'details'])->name('details-tugas-staf')->middleware('auth');
Route::get('/user_staf/detail-tugas-status/{id}', [stafController::class, 'getTugas'])->name('detail-where-staus')->middleware('auth');
Route::get('/user_staf/detail-tugas-priority/{id}', [stafController::class, 'getFilter'])->name('detail-where-priority')->middleware('auth');
Route::resource('/user_staf',stafController::class)->middleware('auth');
// route button pending
Route::put('/pending_tugas/{id}', [stafController::class, 'pending_task'])->name('pending_tugas');
// route button star working
Route::put('/start_working/{id}', [stafController::class, 'start_working_task'])->name('start_working_task');


Route::get('/jabatan/{id}', [UserController::class, 'getJabatan']);
Route::get('user_pimpinan/DetailTask/create/{id}', [TaskController::class, 'getJabatan']);
Route::get('user_pimpinan/DetailTask/createUser/{id}', [TaskController::class, 'getUser']);

Route::resource('/user_staf/riwayat_tugas', riwayatTugasController::class)->middleware('auth');

Route::resource('profil', profilUserControlller::class);


