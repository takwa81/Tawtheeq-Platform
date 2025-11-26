<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Http\Requests\Dashboard\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function account()
    {
        try {
            return view('dashboard.account.index', ['user' => auth()]);
        } catch (\Exception $e) {
            toastr()->error(__('dashboard.error_loading_account') . $e->getMessage());
            return redirect()->route('dashboard.home');
        }
    }

    public function update_account(Request $request)
    {
        try {
            $user = auth()->user();

            $phoneChanged = $request->phone !== $user->phone;

            $user->phone = $request->phone;
            $user->full_name = $request->full_name;
            $user->save();

            if ($phoneChanged) {
                Auth::logout();
                toastr()->success(__('dashboard.account_updated_login_again'));
                return redirect()->route('dashboard.login-form');
            }

            toastr()->success(__('dashboard.account_updated_success'));
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error(__('dashboard.error_updating_account') . $e->getMessage());
            return redirect()->back();
        }
    }

    public function reset_password(ResetPasswordRequest $request)
    {
        try {
            $user = auth()->user();
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::logout();
            toastr()->success(__('dashboard.password_updated_login_again'));
            return redirect()->route('dashboard.login-form');
        } catch (\Exception $e) {
            toastr()->error(__('dashboard.error_updating_password') . $e->getMessage());
            return redirect()->back();
        }
    }

    public function reset_password_form()
    {
        return view('dashboard.account.reset_password');
    }
}