<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was a validation error. Try again.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
//            dd($request->all());
            $user = User::create(request(['name', 'email', 'password']));

            auth()->login($user);

            return response()->json([
                'type' => 'success',
                'message' => 'User successflully registered.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to process the request',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
