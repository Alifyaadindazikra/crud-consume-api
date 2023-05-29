<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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
//mengambil semua data & search
Route::get('/', [StudentController::class, 'index'])->name('home');
//halaman tmbah data
Route::get('/add', [StudentController::class,'create'])->name('add');
//tambh data
Route::post('/add/send', [StudentController::class,'store'])->name('send');
//menampilkan halaman edit dan mengirim satu datanya
Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('edit');
//mengubah data
Route::patch('/update/{id}', [StudentController::class, 'update'])->name('update');
//menghapus dta sementara
Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('delete');
//ambil data sampah
Route::get('/trash',[StudentController::class, 'trash'])->name('trash');
//restore
Route::get('/trash/restore/{id}', [StudentController::class, 'restore'])->name('restore');
//hapus permanent
Route::get('/trash/delete/permanent/{id}', [StudentController::class, 'permanent'])->name('permanent');
