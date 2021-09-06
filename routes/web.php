<?php

use App\Http\Controllers\Administrator\AdminController;
use App\Http\Controllers\Administrator\BerkasController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\GuestController;
use App\Http\Controllers\Administrator\KlasifikasiController;
use App\Http\Controllers\Administrator\OperatorController;
use App\Http\Controllers\Administrator\UnitController;
use App\Http\Controllers\Operator\AllKlasifikasiController;
use App\Http\Controllers\Operator\OperatorBerkasController;
use App\Http\Controllers\Operator\OperatorDashboardController;
use App\Http\Controllers\Operator\OperatorKlasifikasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'  => 'administrator/'],function(){
    Route::get('/',[DashboardController::class, 'dashboard'])->name('administrator.dashboard');
});

Route::group(['prefix'  => 'administrator/manajemen_unit'],function(){
    Route::get('/',[UnitController::class, 'index'])->name('administrator.unit');
    Route::post('/',[UnitController::class, 'post'])->name('administrator.unit.post');
    Route::get('/{id}/edit',[UnitController::class, 'edit'])->name('administrator.unit.edit');
    Route::patch('/',[UnitController::class, 'update'])->name('administrator.unit.update');
    Route::delete('/',[UnitController::class, 'delete'])->name('administrator.unit.delete');
});

Route::group(['prefix'  => 'administrator/manajemen_klasifikasi'],function(){
    Route::get('/',[KlasifikasiController::class, 'index'])->name('administrator.klasifikasi');
    Route::post('/',[KlasifikasiController::class, 'post'])->name('administrator.klasifikasi.post');
    Route::get('/{id}/edit',[KlasifikasiController::class, 'edit'])->name('administrator.klasifikasi.edit');
    Route::patch('/',[KlasifikasiController::class, 'update'])->name('administrator.klasifikasi.update');
    Route::delete('/',[KlasifikasiController::class, 'delete'])->name('administrator.klasifikasi.delete');
});

Route::group(['prefix'  => 'administrator/manajemen_berkas'],function(){
    Route::get('/',[BerkasController::class, 'index'])->name('administrator.berkas');
});

Route::group(['prefix'  => 'administrator/manajemen_operator'],function(){
    Route::get('/',[OperatorController::class, 'index'])->name('administrator.operator');
    Route::post('/',[OperatorController::class, 'post'])->name('administrator.operator.post');
    Route::get('/{id}/edit',[OperatorController::class, 'edit'])->name('administrator.operator.edit');
    Route::patch('/',[OperatorController::class, 'update'])->name('administrator.operator.update');
    Route::delete('/',[OperatorController::class, 'delete'])->name('administrator.operator.delete');
    Route::patch('/update_password',[OperatorController::class, 'updatePassword'])->name('administrator.operator.update_password');
    Route::patch('/nonaktifkan_status/{id}',[OperatorController::class, 'nonAktifkanStatus'])->name('administrator.operator.nonaktifkan_status');
    Route::patch('/aktifkan_status/{id}',[OperatorController::class, 'aktifkanStatus'])->name('administrator.operator.aktifkan_status');
});

Route::group(['prefix'  => 'administrator/manajemen_guest'],function(){
    Route::get('/',[GuestController::class, 'index'])->name('administrator.guest');
    Route::post('/',[GuestController::class, 'post'])->name('administrator.guest.post');
    Route::get('/{id}/edit',[GuestController::class, 'edit'])->name('administrator.guest.edit');
    Route::patch('/',[GuestController::class, 'update'])->name('administrator.guest.update');
    Route::delete('/',[GuestController::class, 'delete'])->name('administrator.guest.delete');
    Route::patch('/update_password',[GuestController::class, 'updatePassword'])->name('administrator.guest.update_password');
    Route::patch('/nonaktifkan_status/{id}',[GuestController::class, 'nonAktifkanStatus'])->name('administrator.guest.nonaktifkan_status');
    Route::patch('/aktifkan_status/{id}',[GuestController::class, 'aktifkanStatus'])->name('administrator.guest.aktifkan_status');
});

Route::group(['prefix'  => 'administrator/manajemen_administrator'],function(){
    Route::get('/',[AdminController::class, 'index'])->name('administrator.admin');
    Route::post('/',[AdminController::class, 'post'])->name('administrator.admin.post');
    Route::get('/{id}/edit',[AdminController::class, 'edit'])->name('administrator.admin.edit');
    Route::patch('/',[AdminController::class, 'update'])->name('administrator.admin.update');
    Route::delete('/',[AdminController::class, 'delete'])->name('administrator.admin.delete');
    Route::patch('/update_password',[AdminController::class, 'updatePassword'])->name('administrator.admin.update_password');
    Route::patch('/nonaktifkan_status/{id}',[AdminController::class, 'nonAktifkanStatus'])->name('administrator.admin.nonaktifkan_status');
    Route::patch('/aktifkan_status/{id}',[AdminController::class, 'aktifkanStatus'])->name('administrator.admin.aktifkan_status');
});


// Route Operator
Route::group(['prefix'  => 'operator/'],function(){
    Route::get('/',[OperatorDashboardController::class, 'dashboard'])->name('operator.dashboard')->middleware('isOperator');
});

Route::group(['prefix'  => 'operator/manajemen_klasifikasi'],function(){
    Route::get('/',[OperatorKlasifikasiController::class, 'index'])->name('operator.klasifikasi_saya');
    Route::post('/',[OperatorKlasifikasiController::class, 'post'])->name('operator.klasifikasi_saya.post');
    Route::delete('/',[OperatorKlasifikasiController::class, 'delete'])->name('operator.klasifikasi_saya.delete');
});

Route::group(['prefix'  => 'operator/semua_klasifikasi'],function(){
    Route::get('/',[AllKlasifikasiController::class, 'index'])->name('operator.all_klasifikasi');
    Route::post('/',[AllKlasifikasiController::class, 'post'])->name('operator.all_klasifikasi.post');
    Route::get('/{id}/edit',[AllKlasifikasiController::class, 'edit'])->name('operator.all_klasifikasi.edit');
    Route::patch('/',[AllKlasifikasiController::class, 'update'])->name('operator.all_klasifikasi.update');
    Route::delete('/',[AllKlasifikasiController::class, 'delete'])->name('operator.all_klasifikasi.delete');
});

Route::group(['prefix'  => 'operator/manajemen_berkas'],function(){
    Route::get('/',[OperatorBerkasController::class, 'index'])->name('operator.berkas');
    Route::get('/tambah_arsip',[OperatorBerkasController::class, 'add'])->name('operator.berkas.add');
    Route::post('/',[OperatorBerkasController::class, 'post'])->name('operator.berkas.post');
    Route::get('/{id}/edit',[OperatorBerkasController::class, 'edit'])->name('operator.berkas.edit');
    Route::patch('/',[OperatorBerkasController::class, 'update'])->name('operator.berkas.update');
    Route::delete('/',[OperatorBerkasController::class, 'delete'])->name('operator.berkas.delete');
});
