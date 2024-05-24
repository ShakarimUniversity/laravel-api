<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/register",
     * tags={"login"},
     * summary="Register a new user",
     * @OA\Parameter(
     * name="name",
     * in="query",
     * description="User's name",
     * required=true,
     * @OA\Schema(type="string")
     * ),

     * @OA\Parameter(
     * name="email",
     * in="query",
     * description="User's email",
     * required=true,
     * @OA\Schema(type="string")
     * ),

     * @OA\Parameter(
     * name="password",
     * in="query",
     * description="User's password",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(response="201", description="User registered successfully"),
     * @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function register(Request $request)
    {
        $validatedData = $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            ]);
         $user = User::create([
             'name' => $validatedData['name'],
             'email' => $validatedData['email'],
             'password' => Hash::make($validatedData['password']),
          ]);
        $token = $user->createToken('main')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * tags={"login"},
     * summary="Authenticate user and generate token",
     * @OA\Parameter(
     * name="email",
     * in="query",
     * description="User's email",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     * name="password",
     * in="query",
     * description="User's password",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(response="200", description="Login successful"),
     * @OA\Response(response="401", description="Invalid credentials")
     * )
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('api_token')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
