<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ExternalUserMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login dengan username/password
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $validated['username'])
            ->orWhere('email', $validated['username'])
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password salah.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'username' => ['User tidak aktif.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user->only(['id', 'name', 'username', 'email', 'role']),
                'token' => $token,
            ],
        ]);
    }

    /**
     * Login khusus mobile - dengan device info
     */
    public function loginMobile(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'device_id' => 'required|string',
            'device_name' => 'nullable|string',
            'device_model' => 'nullable|string',
            'os_type' => 'required|in:android,ios,web',
            'os_version' => 'nullable|string',
        ]);

        // Login user
        $user = User::where('username', $validated['username'])
            ->orWhere('email', $validated['username'])
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak aktif',
            ], 403);
        }

        // Create token dengan device info
        $token = $user->createToken('mobile-' . $validated['device_id'], ['mobile-app'])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user->only(['id', 'name', 'username', 'email', 'role']),
                'token' => $token,
                'device_id' => $validated['device_id'],
                'os_type' => $validated['os_type'],
            ],
        ]);
    }

    /**
     * Validate exam password sebelum mulai exam
     */
    public function validateExamPassword(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'password' => 'required|string',
            'device_id' => 'required|string',
        ]);

        $exam = \App\Models\Exam::findOrFail($validated['exam_id']);
        
        if (!$exam->canStartExam()) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian belum dimulai atau sudah berakhir',
            ], 403);
        }

        $mobileSettings = $exam->mobileSettings;
        if (!$mobileSettings->enable_password_protection) {
            return response()->json([
                'success' => true,
                'message' => 'Tidak ada password protection',
            ]);
        }

        if ($mobileSettings->exam_password !== $validated['password']) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password benar',
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Get current user info
     */
    public function getCurrentUser(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->only(['id', 'name', 'username', 'email', 'role']),
        ]);
    }
