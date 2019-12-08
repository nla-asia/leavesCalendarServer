<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('employees/login', 'EmployeeAPIController@login');
Route::post('employees/register', 'EmployeeAPIController@register');


Route::middleware(['auth:api'])->group(function () {
   
    Route::post('employees/logout', 'EmployeeAPIController@logout');
    Route::get('employees/me', 'EmployeeAPIController@show');
    Route::post('employees/refresh_token', 'EmployeeAPIController@refresh');
    Route::get('employees', 'EmployeeAPIController@index');

    Route::get("leaves/mine", 'LeaveAPIController@my_index');
    Route::resource('leaves', 'LeaveAPIController');
    Route::resource('holidays', 'HolidayAPIController');
    Route::resource('leave_types', 'LeaveTypeAPIController');
    

});





