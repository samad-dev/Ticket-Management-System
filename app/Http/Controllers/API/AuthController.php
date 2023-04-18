<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password);
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $days =  365;
        $minutes =  60 * 60 * $days;
        config()->set('jwt.ttl', $minutes);
        $claims = ['exp' => (int)Carbon::now()->addYear()->getTimestamp(), 'remember' => 1, 'type' => 1];

        $token = auth()->claims($claims)->attempt(['email' => $email, 'password' => $password]);

        if ($token) {
            $user = User::where('email', $email)->first();

            if ($user && $user->status === 'deactive') {
                $exception = new ApiException('User account disabled', null, 403, 403, 2015);
                return ApiResponse::exception($exception);
            }

            /** @var Admin $user */
            $user = auth()->user();
            //          $payload = auth()->payload();

            $expire = \Carbon\Carbon::now()->addYear(1);
            return ApiResponse::make('Logged in successfully', [
                'token' => $token,
                'user' => $user->load('roles', 'roles.perms', 'roles.permissions'),
                'expires' => $expire,
                'expires_in' => auth()->factory()->getTTL(),
            ]);
        }

        $exception = new ApiException('Wrong credentials provided', null, 403, 403, 2001);
        return 'samad';

    }
}
