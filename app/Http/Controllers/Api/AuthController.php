<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private array $rules;
    private array $messages;

    public function __construct()
    {
        $this->rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        $this->messages = [
            'required' => 'The :attribute field is required',
            'min' => 'The :attribute field is too short'
        ];
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'login failed',
                'errors' => [
                    'parameters' => 'check request paremeters'
                ]
            ], status: 422);

        } else {

            $credentials = request(['email', 'password']);

            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'login failed',
                    'errors' => [
                        'credentials' => 'invalid credentials'
                    ]
                ], status: 422);
            }
    
            $user = User::where('email', $request->email)->first();

            $authToken = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'access_token' => $authToken
            ]);
        }
    }
}
