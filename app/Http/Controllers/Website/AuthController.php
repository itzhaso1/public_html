<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Category};
use Illuminate\Support\Facades\{Auth,Hash};
class AuthController extends Controller {
    public function showLoginForm()
    {
        $categories = Category::with(['translations', 'media', 'children.translations'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        return view('website.auth.login', [
            'categories' => $categories,
            'pageTitle' => trans('site/site.login_page_title'),
            'breadcrumbs' => [
                ['title' => __('site/site.login_page_title')],
            ]
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function showRegisterForm()
    {
        $categories = Category::with(['translations', 'media', 'children.translations'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        return view('website.auth.register', [
            'categories' => $categories,
            'pageTitle' => trans('site/site.register_page_title'),
            'breadcrumbs' => [
                ['title' => __('site/site.register_page_title')],
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6',
            'status'   => 'nullable',
        ]);
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'status'   => 'active',
        ]);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}