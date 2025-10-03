<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    //

    // Registration API
    public function register(UserRegistration $request)
    {
        //
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::query()
            ->create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'New user created successfully'
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $response['token'] = $user->createToken('BlogApp')->plainTextToken;
            $response['email'] = $user->email;
            $response['name'] = $user->name;

            return response()->json([
                'status' => 'success',
                'message' => 'Logged in successful',
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'status' => 'fails',
                'message' => 'No user found matching your credentials'
            ], 400);
        }
    }

    public function profile()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ], 200);
    }
}
