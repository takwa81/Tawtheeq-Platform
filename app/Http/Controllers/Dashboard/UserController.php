<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => __('messages.password_changed_successfully'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }
}
