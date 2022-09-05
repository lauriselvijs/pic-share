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
}
