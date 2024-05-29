<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function register_page() {
        if(auth()->check()){
            return redirect()->route('project.index');
        }
        return view('auth.register');
    }

    public function login_page() {
        if(auth()->check()){
            return redirect()->route('project.index');
        }
        return view('auth.login');
    }

    // POST [ name, email, password ]
    public function register (Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);

    }

    // POST [ email, password ]
    public function login (Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        session(['access_token' => $accessToken]);
        return to_route('project.index');
    }

    // GET [Auth: Token]
    public function profile () {
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

    // GET [ Auth: Token ]
    public function logout () {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }

    
}
