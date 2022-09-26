<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\StoreAuthRequest;

class AuthController extends Controller
{
    /**
     * Show sign up user form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Create new user
     *
     * @param StoreAuthRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(StoreAuthRequest $request)
    {
        // TODO: 
        // [] - add agreement checked to user table as column
        $formData = $request->validated();

        // Hash password
        $formData['password'] = bcrypt($formData['password']);

        // Create user
        $user = User::create($formData);

        // Login user
        auth()->login($user);

        return redirect()->route('posts.index')->with('message',  __('user.created'));
    }

    /**
     * User logout
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', __('user.logged_out'));
    }

    /**
     * Show log in user form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('auth.login');
    }


    // kawuzipilo@mailinator.com
    // 123456

    /**
     * Authenticate user
     *
     * @param AuthRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(AuthRequest $request)
    {
        $formData = $request->validated();

        if (auth()->attempt($formData, $request->remember)) {
            $request->session()->regenerate();
            // TODO:
            // [] - For flash msg create const values
            return redirect()->route('posts.index')->with('message',  __('user.logged_in'));
        } else {
            return back()->withErrors(['password' => __('auth.failed')])->onlyInput('password');
        }
    }
}
