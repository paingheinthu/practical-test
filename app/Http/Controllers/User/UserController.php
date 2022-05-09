<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Contracts\UserInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(protected UserInterface $userService)
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email:rfc,dns,filter',
                'password' => 'required|string|min:8',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()
                ],
                422
            );
        }

        if ($this->userService->getUser($request->email)) {
            return response()->json(
                [
                    'message' => 'your already registered'
                ],
                406
            );
        }

        if ($user = $this->userService->registerUser($request->name, $request->email, $request->password)) {
            return response()->json(
                [
                    'data' => $user
                ]
            );
        }

        return response()->json(
            [
                'message' => 'register failed'
            ],
            406
        );
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email:rfc,dns,filter',
                'password' => 'required_with:email|string|min:8',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()
                ],
                422
            );
        }

        $user = $this->userService->getUser($request->email);
        if (!$user) {
            return response()->json(
                [
                    'message' => 'User not found.'
                ],
                404
            );
        }

        if (!Hash::check($request->password, $user?->password)) {
            return response()->json(
                [
                    'message' => 'Invalid credentials'
                ],
                400
            );
        }

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $user->createToken('User-Token')->plainTextToken
            ]
        ]);
    }
}
