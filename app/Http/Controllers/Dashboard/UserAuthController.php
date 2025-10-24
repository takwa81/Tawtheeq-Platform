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

                toastr()->success('تم تسجيل الدخول بنجاح');
                return redirect()->route('dashboard.home');
            }

            toastr()->error('رقم الهاتف أو كلمة المرور غير صحيحة');
            return redirect()->back()->withErrors(['phone' => 'بيانات الدخول غير صحيحة'])->withInput();
        } catch (\Exception $e) {
            toastr()->error('حدث خطأ أثناء محاولة تسجيل الدخول: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            toastr()->success('تم تسجيل الخروج بنجاح');
            return redirect()->route('dashboard.login-form');
        } catch (\Exception $e) {
            toastr()->error('حدث خطأ أثناء تسجيل الخروج: ' . $e->getMessage());
            return redirect()->route('dashboard.home');
        }
    }
}
