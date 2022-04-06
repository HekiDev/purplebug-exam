<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
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


//Login
Route::post('user_login',[UserController::class, 'user_login'])->name('user_login');
//Logout
Route::get('logout',[UserController::class, 'logout'])->name('logout');
//add role
Route::post('add_role',[UserController::class, 'add_role'])->name('add_role');
//add User
Route::post('add_user',[UserController::class, 'add_user'])->name('add_user');
//add category
Route::post('add_category',[ExpenseController::class, 'add_category'])->name('add_category');
//add expense
Route::post('add_expense',[ExpenseController::class, 'add_expense'])->name('add_expense');
//Change Password
Route::post('change_password',[UserController::class, 'change_password'])->name('change_password');

//ajax requests
Route::get('role_data/{id}',[RoleController::class, 'role_data']);
Route::get('user_data/{id}',[UserController::class, 'user_data']);
Route::get('category_data/{id}',[ExpenseController::class, 'category_data']);
Route::get('expense_data/{id}',[ExpenseController::class, 'expense_data']);

//update role
Route::post('edit_role',[RoleController::class, 'edit_role'])->name('edit_role');
//delele
Route::post('delete_role',[RoleController::class, 'delete_role'])->name('delete_role');
//delele user
Route::post('delete_user',[UserController::class, 'delete_user'])->name('delete_user');
//delele category
Route::post('delete_category',[ExpenseController::class, 'delete_category'])->name('delete_user');
//delele expense
Route::post('delete_expense',[ExpenseController::class, 'delete_expense'])->name('delete_expense');
//update role
Route::post('edit_user',[UserController::class, 'edit_user'])->name('edit_user');
//update role
Route::post('edit_category',[ExpenseController::class, 'edit_category'])->name('edit_category');
//update expense
Route::post('edit_expense',[ExpenseController::class, 'edit_expense'])->name('edit_expense');

//middleware Validation
Route::group(['middleware'=>['needToLogIn']], function(){
    Route::get('/',[UserController::class, 'login']);
    Route::get('/dashboard',[DashboardController::class, 'dashboard']);
    Route::get('roles',[RoleController::class, 'roles']);
    Route::get('users',[userController::class, 'users']);
    Route::get('categories',[ExpenseController::class, 'categories']);
    Route::get('expenses',[ExpenseController::class, 'expenses']);
    Route::get('account',[UserController::class, 'account']);
});

