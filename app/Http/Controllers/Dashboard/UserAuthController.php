<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }


    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $user = auth()->user();

                // if ($user->status !== 'active') {
                //     toastr()->error('حسابك غير مفعل. يرجى التواصل مع الإدارة');
                //     return redirect()->route('dashboard.login-form');
                // }

                toastr()->success(__('dashboard.login_success'));
                return redirect()->route('dashboard.home');
            }

            toastr()->error(__('dashboard.invalid_credentials'));
            return redirect()->back()->withErrors(['phone' => __('dashboard.invalid_credentials')])
                ->withInput();
        } catch (\Exception $e) {
            toastr()->error(__('dashboard.login_error', ['message' => $e->getMessage()]));
            return redirect()->back()->withInput();
        }
    }


    public function logout(Request $request)
    {
        try {
            Auth::logout();
            // $request->session()->invalidate();
            $request->session()->regenerateToken();

            toastr()->success(__('dashboard.logout_success'));
            return redirect()->route('dashboard.login-form');
        } catch (\Exception $e) {
            toastr()->error(__('dashboard.logout_error', ['message' => $e->getMessage()]));
            return redirect()->route('dashboard.home');
        }
    }
}