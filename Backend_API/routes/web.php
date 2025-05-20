<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
   return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/',[DepartmentsController::class,'index'])->name('get');
});

//Route::get('/',[DepartmentsController::class,'index'])->name('get');
//Route::post('/store',[DepartmentsController::class,'store'])->name('store_brand');
//Route::put('/update/{id}',[DepartmentsController::class,'update'])->name('update_brand');
//Route::delete('/delete/{id}',[DepartmentsController::class,'delete'])->name('delete_brand');
//Route::get('/no data',[DepartmentsController::class,'handler'])->name('handle_no_data');

Route::get('/login', [ProfileController::class, 'login'])->name('login');


//require __DIR__.'/auth.php';
