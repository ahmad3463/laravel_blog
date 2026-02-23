<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function registerUser(Request $req)
    {
        $data = $req->json()->all(); // store JSON input into $data

        $validator = Validator::make($data, [
            'name' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

     $user =   User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_pass' => $data['password'],
           
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user
        ]);
    }

    function loginUsers(Request $req){

        $req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::where('email', $req->email)->first();

        if(!$user || !Hash::check($req->password, $user->password)){
            return response()->json([
                'message' => 'invalid Credentail'
            ], 401);
        }
            if($user->role === 'admin'){
                return response()->json([
                    'message'=>'welcome admin'
                ]);
            }
        return response()->json([
            'success'=> true,
            'message'=> 'login successfully',
            'user'=> $user
        ]);
    }
}
