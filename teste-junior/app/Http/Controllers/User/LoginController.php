<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);

        try {
            if (Auth::attempt($credentials, isset($request->remember))) {
                $request->session()->regenerate();
            }

            return response()->json([
                'type' => 'success',
                'body' => [],
                'message' => 'User logged in successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'Something went wrong. Try again later',
                'errors' => [$th->getMessage()]
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to logout. Please, try again later.',
                'errors' => [$th->getMessage()]
            ]);
        }
    }
}
