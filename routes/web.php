<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;

Route::get('/userinfo/regist', [UserController::class, 'showRegistUserInfo'])
->name('userinfo.regist');

Route::post('/userinfo/regist', [UserController::class, 'registUserInfo'])
->name('userinfo.regist');

Route::get('/userinfo', [UserController::class, 'showUserInfo'])
->middleware('auth')
->name('userinfo');

Route::get('/userinfo/update', [UserController::class, 'showUpdateUserInfo'])
->middleware('auth')
->name('userinfo.update');

Route::post('/userinfo/update', [UserController::class, 'updateUserInfo'])
->middleware('auth')
->name('userinfo.update');

Route::get('/userinfo/delete', [UserController::class, 'showDeleteUserInfo'])
->middleware('auth')
->name('userinfo.delete');

Route::post('/userinfo/delete', [UserController::class, 'deleteUserInfo'])
->middleware('auth')
->name('userinfo.delete');

Route::get('/deviceinfo/regist', [DeviceController::class, 'showRegistDeviceInfo'])
->middleware('auth')
->name('deviceinfo.regist');

Route::post('/deviceinfo/regist', [DeviceController::class, 'registDeviceInfo'])
->middleware('auth')
->name('deviceinfo.regist');

Route::get('/deviceinfo/{device_id}', [DeviceController::class, 'showDeviceInfo'])
->middleware('auth')
->name('deviceinfo');

Route::get('/devicelist', [DeviceController::class, 'showDeviceList'])
->middleware('auth')
->name('devicelist');

Route::get('/deviceinfo/update/{device_id}', [DeviceController::class, 'showUpdateDeviceInfo'])
->middleware('auth')
->name('deviceinfo.update');

Route::post('/deviceinfo/update/{device_id}', [DeviceController::class, 'updateDeviceInfo'])
->middleware('auth')
->name('deviceinfo.update');

Route::get('/deviceinfo/delete/{device_id}', [DeviceController::class, 'showDeleteDeviceInfo'])
->middleware('auth')
->name('deviceinfo.delete');

Route::post('/deviceinfo/delete/{device_id}', [DeviceController::class, 'deleteDeviceInfo'])
->middleware('auth')
->name('deviceinfo.delete');

Route::get('/login', [AuthController::class, 'showLogin'])
->name('login');

Route::post('/login', [AuthController::class, 'login'])
->name('login');

Route::get('/logout', [AuthController::class, 'getLogout'])
->middleware('auth')
->name('logout');

Route::post('/logout', [AuthController::class, 'logout'])
->middleware('auth')
->name('logout');

Route::get('/top', [UserController::class, 'showTop'])
->middleware('auth')
->name('top');

Route::get('/devicelist/wake/', [DeviceController::class, 'getWakeDevices'])
->middleware('auth')
->name('devicelist.wake');

Route::post('/devicelist/wake/', [DeviceController::class, 'wakeDevices'])
->middleware('auth')
->name('devicelist.wake');
