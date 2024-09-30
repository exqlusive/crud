<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginUserRequest;
use App\Http\Requests\Authentication\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthenticationController extends Controller
{
    // Register a new user
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    /**
     * Login and create a token
     *
     * @throws ValidationException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $abilities = $this->getAbilitiesForRole($user->role);

        // Create a token with specific abilities
        $token = $user->createToken('api-token', $abilities)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    // Get the authenticated user
    public function user(Request $request)
    {
        return $request->user();
    }

    // Logout and delete the token
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    protected function getAbilitiesForRole(string $role): array
    {
        return match ($role) {
            'admin' => ['manage-locations', 'manage-reservations', 'view-users'],
            'location_manager' => ['view-locations', 'manage-reservations'],
            default => ['view-reservations'],
        };
    }
}
