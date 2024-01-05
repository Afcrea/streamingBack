<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BroadcastController;
use App\Models\User;

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
// Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
//     return redirect('/api/getemail')->with('email', $request->input('email'));
// });



Route::post('/login', [AuthController::class, 'login']); // 로그인

Route::middleware('auth:sanctum')->post('/authLogout', [AuthController::class, 'logout']); // 로그아웃

Route::post('/regist', [UserController::class, 'regist']); // 회원 가입

Route::middleware('auth:sanctum')->get('/getStreamkey', [BroadcastController::class, 'getStreamkey']); // 스트림키생성 후 발급

Route::middleware('auth:sanctum')->post('/startStream', [BroadcastController::class, 'startStream']); // 방송 시작

Route::middleware('auth:sanctum')->post('/endStream', [BroadcastController::class, 'endStream']); // 방송 종료

Route::middleware('auth:sanctum')->post('/getUser', [UserController::class, 'getUser']); // 유저 정보

Route::get('/getStream', [BroadcastController::class, 'getStream']); // 방송 목록

Route::get('/getHost/{user_id}', [BroadcastController::class, 'getHost']); // 호스트 정보

// Route::post('/sanctum/token', function (Request $request) {
//     // echo "122";exit;
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     $user = User::where('email', $request->email)->first();

//     // if (! $user || ! Hash::check($request->password, $user->password)) {
//     //     throw ValidationException::withMessages([
//     //         'email' => ['The provided credentials are incorrect.'],
//     //     ]);
//     // }
//     // createToken의 인자는 token table의 name 컬럼 값에 저장된다. 

//     if (! $user) {
//         throw ValidationException::withMessages([
//             'email' => ['The provided credentials are incorrect.'],
//         ]);
//     }

//     return $user->createToken('token-name')->plainTextToken;
// });

// Route::get('/getemail', function (Request $request) {
//     // 쿼리 문자열을 통한 데이터 추출
//     $email = session('email');
//     // 라우트 파라미터를 통한 데이터 추출 (예: /getemail/{email})
//     // $email = $request->route('email');
//     return $email;
// });
