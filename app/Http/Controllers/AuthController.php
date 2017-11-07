<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
  
    public function login(Request $request)
    {   

        $credentials = $request->only('email', 'password');
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
            // return response()->json(compact('token'));
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function register(Request $request) 
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'phone' => 'required|min:11|max:15',
            'address' => 'required|max:255',
            'location' => 'required|max:255'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => app('hash')->make($request->input('password')),
            'phone' => $request->get('phone'),
            'address' => $request->input('address'),
            'location' => $request->input('location')
        ]);
        
        
             $token = $this->guard()->fromUser($user);

             return $this->respondWithToken($token);
          
        
    }

    public function authUser()
    {
        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

 
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     *  * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    
    public function guard()
    {
        return Auth::guard();
    }

}
