<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }
    public function index()
    {
        $user = User::all();
        
        if(!$user){
            return response()->json(['data' => '404, data not found'], 400);
        }
        return response()->json(['data' => $user], 200);
        
    }
    
    public function store(Request $request)
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

        return response()->json(['data' => $user], 201);

    }

    public function show($id)
    {
        $user =  User::find($id);

        if (!$user) {
            return response()->json(['data' => 'user not found'], 400); 
        }else {
            return response()->json(['data' => $user], 200);
        }
    }

    public function update(Request $request, $id) 
    {
        
        

        $user = User::find($id);

        if(!$user || $user->id!= Auth::id()) {
            return response()->json(['data' => 'this is wrong'], 400);
        } else {
            $this->validate($request, [
                'name'  => 'required',
                'email' => 'required|email',
                'password' => 'required|min:4',
                'phone' => 'required|min:11|max:15',
                'address' => 'required|max:255',
                'location' => 'required|max:255'
            ]);
            
                    $user->password = app('hash')->make($request->input('password'));
                    $user->phone = $request->input('phone');
                    $user->address = $request->input('address');
                    $user->image_url = $request->file('image_url');
                    $user->location = $request->input('location');
            
                    $user->save();
            
            return response()->json(['data' => $user], 200);
            
        }

        



    }

    public function destroy($id)
    {
        $user = User::find($id);

        if(!$user || $user->id!= Auth::id()) {
            return response()->json(['data' => 'Access denied'], 400);
        }else {
            $user->delete();
            return response()->json(['data' => 'Operation successful'], 200);
        }
        
    }
 
}
