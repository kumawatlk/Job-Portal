<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get("/",[HomeController::class,"index"]);
Route::get("/contact",[HomeController::class,"contact"]);



Route::group(['account'],function(){
    Route::group(['middleware'=>'guest'],function(){
        Route::get("/account/regitration",[AccountController::class,"regitration"])->name('account.regitration');
        Route::post("/account/proccess-register",[AccountController::class,"proccessregisration"]);
        Route::get("/account/login",[AccountController::class,"login"])->name('account.login');
        Route::post("/account/login/authenticate",[AccountController::class,"authenticate"])->name('account.authenticate');
    });  
    Route::group(['middleware'=>'auth'],function(){
        Route::get("/account/profile",[AccountController::class,'profile'])->name('profile');
        Route::post("/account/profile_update",[AccountController::class,'profile_update'])->name('account.profile_update');
        Route::post("/account/profilepic",[AccountController::class,'profilepic'])->name('account.profilepic');
        Route::get("/account/logout",[AccountController::class,'logout'])->name('account.logout');
    });  
});