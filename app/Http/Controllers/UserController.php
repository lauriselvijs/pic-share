<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Show sign up user form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view("user.sign-up");
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
        $formData = $request->validate([
            "name" => "required|string:min:3",
            "email" => "required|email|unique:users",
            "agreement" => "required",
            "password" => "required|string|confirmed|min:6",
        ]);

        // Hash password
        $formData["password"] = bcrypt($formData["password"]);

        // Create user
        $user = User::create($formData);

        // Login user
        auth()->login($user);

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Your PicShare account created successfully!'));
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

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Successfully logged out!'));
    }

    /**
     * Show log in user form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view("user.login");
    }

    public function authenticate(Request $request)
    {
        $formData = $request->validate([
            "email" => "required|email",
            "password" => "required|string",
        ]);

        if (auth()->attempt($formData)) {
            $request->session()->regenerate();
            // TODO:
            // [] - For flash msg create const values
            return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'You have been logged in successfully!'));
        } else {
            return back()->withErrors(["password" => "Invalid credentials"])->onlyInput("password");
        }
    }
}
