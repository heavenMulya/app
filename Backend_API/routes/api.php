<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\ERP\Auth\authCheckController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\foodItemsController;
use App\Http\Controllers\orderItemsController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\AuthNew\loginCheckController;

//Route::Post('login',[loginCheckController::class,'login']);

Route::post('/recipe/save',[RecipeController::class,'store']);
Route::get('/recipe/get',[RecipeController::class,'index']);
Route::get('/recipe/get/{id}',[RecipeController::class,'Show']);
Route::PUT('/recipe/update/{id}',[RecipeController::class,'update']);
Route::Delete('/recipe/delete/{id}',[RecipeController::class,'delete']);

Route::post('/foodItems/save',[foodItemsController::class,'store']);
Route::get('/foodItems/get',[foodItemsController::class,'index']);
Route::get('/foodItems/get/{id}',[foodItemsController::class,'Show']);
Route::PUT('/foodItems/update/{id}',[foodItemsController::class,'update']);
Route::Delete('/foodItems/delete/{id}',[foodItemsController::class,'delete']);


Route::post('/orderItems/save',[orderItemsController::class,'store']);
Route::get('/orderItems/get',[orderItemsController::class,'index']);
Route::get('/orderItems/get/{id}',[orderItemsController::class,'Show']);
Route::PUT('/orderItems/update/{id}',[orderItemsController::class,'update']);
Route::Delete('/orderItems/delete/{id}',[orderItemsController::class,'delete']);

Route::get('/kitchen/orders', [ordersController::class, 'getOrders']);
Route::post('/order/save',[ordersController::class,'store']);
Route::get('/order/get',[ordersController::class,'index']);
Route::get('/order/get/{id}',[ordersController::class,'Show']);
Route::PUT('/order/update/{id}',[ordersController::class,'update']);
Route::PUT('/orderstatus/update/{id}',[ordersController::class,'updateOrderStatus']);
Route::Delete('/order/delete/{id}',[ordersController::class,'delete']);

