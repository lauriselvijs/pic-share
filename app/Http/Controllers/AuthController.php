<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show sign up user form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('auth.sign-up');
    }

    /**
     * Create new user
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // TODO: 
        // [] - add agreement checked to user table as column
        // [] - add username field
        $formData = $request->validate([
            'name' => 'required|string:min:3',
            'email' => 'required|email|unique:users',
            'agreement' => 'required',
            'password' => 'required|string|confirmed|min:6',
        ]);

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
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $formData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

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
