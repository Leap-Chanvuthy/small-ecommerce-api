<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});



 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login' , [AuthController::class , 'login']) ;
 



  Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


// User 
Route::get('/users', [UserController::class, 'getUser']) -> middleware('role:ADMIN');
Route::delete('/deleteusers/{id}' , [UserController::class , 'destroy'])-> middleware('role:ADMIN');
Route::put('/update/{id}' , [UserController::class , 'update'])-> middleware('role:ADMIN');



//Product

Route::get('/product' , [ProductController::class , 'index'])->middleware('role:ADMIN')  ;
Route::post('/create-product',  [ProductController::class , 'createProduct'])->middleware('role:ADMIN')   ; 
Route::patch('/update-product/{id}',  [ProductController::class , 'updateProduct'])->middleware('role:ADMIN')   ; 
Route::delete('/delete/{id}',  [ProductController::class , 'destroy'])->middleware('role:ADMIN')   ; 



//Category 

Route::post('/create-category', [CategoryController::class, 'create'])->middleware('role:ADMIN');


