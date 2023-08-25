<?php

namespace App\Http\Controllers;
//1use
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;  //pahoc

class AuthController extends Controller
{
    public function register(RegisterRequest $request) // anvanapoxutyun
    {
        $data = $request->validated();
        $imageName = Str::random(32).".".$data['image']->getClientOriginalExtension();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'image' => $imageName,
            'password' => Hash::make($data['password'])
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;  // token generation auto
        $cookie = cookie('token',$token,60 * 24);   //name|token|1 or jamketov  hishecumy

        return response()->json([
            'user' => new UserResource($user),
        ])->withCookie($cookie);
    }
public function login(LoginRequest $request)
{
    $data = $request->validated();
    $user = User::where('email',$data['email'])->first(); // $data miji emial ->first() bolor toxy
    if (!$user || !Hash::check($data['password'],$user->password)) {
        return response()->json([
            'messege' => 'email or password is wrong'
        ],401);
    }
    Storage::disk('public')->put($imageName,file_get_contents($data['iamge']));
    $token = $user->createToken('auth_token')->plainTextToken;
    $cookie = cookie('token',$token,60 * 24);
    return response()->json([
        'user' => new UserResource('user')
    ])->withCookie($cookie);;
}
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();   //currentAccessToken() vercnum e yntacik tokeny yev ayt tokenin jnjum enq
    $cookie = cookie()->forget('token');  //forget() moranum e
    return response()->json([
        'messege' => 'you have logged out'
    ])->whithCookie($cookie);
}
public function user(Request $request)
{
    return new UserResource($request->user());
}
}