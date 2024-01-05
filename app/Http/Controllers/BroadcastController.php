<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class BroadcastController extends Controller
{
    public function getStreamkey() {
        $streamkey = auth()->user()->email;
        // email을 스트림키로 사용 추후 수정
        return response()->json(['streamkey' => $streamkey], 201);
    }

    public function startStream(Request $request) {
        try {
            // $rules = [
            //     'title' => 'required|string|max:255',
            //     'description' => 'string|nullable',
            //     'category' => 'required|string|max:255',
            // ];
    
            // 유효성 검사 실행
            // $this->validate($request, $rules);

            $log = new Logger('logname');
            $log->pushHandler(new StreamHandler(storage_path('logs/laravel.log'), Logger::INFO));
            $log->info($request);
            // 방송 등록
            $streamKeyEncrypted = auth()->user()->email . 'encrypted';
            $broadcast = Broadcast::create([
                'user_id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'category' => $request->input('category'),
                'stream_key' => $streamKeyEncrypted // 수정 예정
            ]);

            return response()->json(['message' => 'broadcast registered successfully'], 201);
        } catch (UniqueConstraintViolationException $e) {
            // 중복된 이메일이 발생했을 때 처리
            return response()->json(['error' => 'Duplicate entry. User with this email already has an active broadcast.'], 401);
        } catch (ValidationException $e) {
            // 유효성 검사 실패 시 처리
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // 기타 예외 처리
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function endStream(Request $request) {
        // $broadcast = Broadcast::find(auth()->user()->id);
        $broadcast = Broadcast::where('user_id', auth()->user()->id)->first();
        $broadcast->delete();

        return response()->json(['message' => 'your stream ended'], 201);
    }

    public function getStream() {
        try {
            // Broadcast 테이블의 모든 레코드를 가져옴
            $broadcasts = Broadcast::all();
    
            // JSON 형식으로 응답
            return response()->json(['broadcasts' => $broadcasts], 200);
        } catch (\Exception $e) {
            // 오류 발생 시 예외 처리
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getHost($user_id) {
        $Host = Broadcast::where('user_id', $user_id);

        return response()->json(['Host' => $Host->first()], 200);
    }
}
