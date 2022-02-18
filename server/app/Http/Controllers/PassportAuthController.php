<?php
namespace App\Http\Controllers;
use App\Http\Requests\AuthRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(AuthRequest $authRequest)
    {
        $user = User::create([
            'name' => $authRequest->name,
            'email' => $authRequest->email,
            'password' => bcrypt($authRequest->password)
        ]);
        if($user){
            $token = $user->createToken('LaravelAuthApp')->accessToken;
            auth()->loginUsingId($user->id);
            return response()->json(['token' => $token,'user' => auth()->user(),'msg' => 'You are successfully registered,Welcome to Home Page'], 200);
        }
        return response()->json(['msg' => 'row failed']);
    }

    /**
     * Login
     */
    public function login(AuthRequest $authRequest)
    {
        $data = [
            'email' => $authRequest->email,
            'password' => $authRequest->password
        ];
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token, 'user' => auth()->user(), 'roles' => auth()->user()->roles,"msg" => "Welcome To Home Page"], 200);
        } else {
            return response()->json(['msg' => 'Invalid Email or Password'], 401);
        }
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();
        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        $accessToken->revoke();
        return response()->json(['status' => 200]);
    }

    public function forget(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            if($request->password == $request->re_password){
                $user->password = Hash::make($request['password']);
                auth()->loginUsingId($user->id);
                $token = $user->createToken('LaravelAuthApp')->accessToken;
                $user->save();
                return response()->json(['token' => $token, 'user' => auth()->user(), 'roles' => auth()->user()->roles,'msg' => 'Password Updated']);
            }
            return response()->json(['msg' => 'Password is Invalid']);
        }
        return response()->json(['msg' => 'E-mail is not defined,Please send your e-mail']);
    }
}
