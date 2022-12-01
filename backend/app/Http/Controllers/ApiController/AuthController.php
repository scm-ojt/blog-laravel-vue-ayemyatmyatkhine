<?php

namespace App\Http\Controllers\ApiController;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * user register
     * @param Illuminate/Request/UserRequest $request
     * @return $success
     */
    public function register(UserRequest $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->created_at = Date('Y-m-d');
        $user->save();
        
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json(['data' => $success , 'successMessage' => 'User create successfully.']);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['errorMessage' => "Email or password is incorrect."] , 401);
        }
        else {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user'] = $user;
            return response()->json(['data' => $success , 'successMessage' => "User login successfully."]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['successMessage' => "Logout successfully."]);
    }
}
