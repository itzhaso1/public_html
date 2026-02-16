<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the admin's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // ✅ التحقق باستخدام guard admin
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // ✅ جلب الأدمن الصحيح
        $admin = Auth::guard('admin')->user();

        // ✅ تحديث كلمة المرور مع تشفير
        $admin->password = Hash::make($request->password);
        $admin->save();

        // ✅ إعادة تسجيل الدخول (يمنع الطرد)
        Auth::guard('admin')->login($admin);

        return back()->with('status', 'password-updated');
    }
}
