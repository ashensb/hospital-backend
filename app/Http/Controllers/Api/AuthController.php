<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 1. Login Function (UI එකේ හැම role එකකටම)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:patient,doctor,nurse,admin'
        ]);

        $user = User::where('email', $request->email)->first();

        // User ව නැත්නම් හෝ Password එක වැරදි නම්
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Login වෙන්න හදන role එක සහ user ගේ role එක ගැලපෙනවද බලමු
        if ($user->role !== $request->role) {
            throw ValidationException::withMessages([
                'role' => ['You do not have permission to login as ' . $request->role],
            ]);
        }

        // Sanctum Token එක හදන්න
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // 2. Patient Registration (UI 5 වෙනි පින්තූරය)
    public function registerPatient(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string',
            'password' => 'required|string|min:12|confirmed', // UI එකේ 12 characters ඉල්ලනවා
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Patient registered successfully',
            'access_token' => $token,
            'user' => $user
        ], 201);
    }

    // 3. Logout Function
    public function logout(Request $request)
    {
        // දැනට ඉන්න user ගේ token එක delete කරන්න
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logged out successfully']);
    }
}