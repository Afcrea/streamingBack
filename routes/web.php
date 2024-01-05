<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
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
//     return "User::all()";
// });

Route::get('/', function () {
    return "main";
});

Route::get('/login', function () {
    return true;
});


Route::get('/user/{name}', function ($name) {
    $user = User::where('name', $name)->first();


    if ($user) {
        return $user;
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
});

Route::post('/user/find', function (request $request) {
    $user = User::where('name', $request->input('name'))->first();


    if ($user) {
        return $user;
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
});

Route::get('/index', function () {
    return view('/vendor/l5-swagger/index');
});


