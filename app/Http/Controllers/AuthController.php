<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\SendTaskAssignedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Something went wrong!',
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);

    }

    // POST [ email, password ]
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Something went wrong!',
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();

        if (auth()->attempt($data)) {
            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            $request->cookie('passport_access_token', $accessToken);
            return response()->json([
                'user' => Auth::user(),
                'access_token' => $accessToken
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
                'data' => $data
            ]);
        }
    }

    // GET [Auth: Token]
    public function profile (Request $request) {
        $users = User::all();
        
        return response()->json([
            'user' => Auth::user(),
            'role' => $users->map(function($user){
                return $user->role;
            })
        ]);
    }

    // GET [ Auth: Token ]
    public function logout (Request $request) {
        Auth::logout();
        return response()->json([
            'message' => 'User logged out successfully',
        ]);
    }

    public function get_notifications() {
        $notifications = Auth::user()->unreadNotifications;
        $notifications->markAsRead();
        return response()->json([
            'notifications' => $notifications
        ]);
    }

    
}
