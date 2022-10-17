<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\StoreAuthRequest;
use App\Services\AuthService;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService)
    {
        $this->authService = $authService;
    }

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
        $user = $this->authService->store($request->validated());

        auth()->login($user);

        return redirect()->route('verification.notice')->with('message',  __('user.created'));
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

        $this->authService->invalidate($request->session());

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
    // 12345678

    /**
     * Authenticate user
     *
     * @param AuthRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(AuthRequest $request)
    {
        if ($this->authService->authenticate($request->session(), $request->validated(), $request->has('remember'))) {
            return redirect()->route('posts.index')->with('message',  __('user.logged_in'));
        }

        return back()->withErrors(['password' => __('auth.failed')])->onlyInput('password');
    }
}
