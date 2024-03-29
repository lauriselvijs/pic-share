<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreAuthRequest;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService)
    {
    }

    /**
     * Show sign up user form
     */
    public function create(): View
    {
        return view('auth.create');
    }

    /**
     * Create new user
     */
    public function store(StoreAuthRequest $request): RedirectResponse
    {
        $this->authService->storeAndLogIn($request->safe(), $request->session());

        return redirect()->route('verification.notice')->with('message',  __('user.created'));
    }

    /**
     * User logout
     */
    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('home')->with('message', __('user.logged_out'));
    }

    /**
     * Show log in user form
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Authenticate user
     */
    public function authenticate(AuthRequest $request): RedirectResponse
    {
        if ($this->authService->authenticate($request->safe()->toArray(), $request->has('remember'))) {
            return redirect()->intended(route('posts.index'))->with('message',  __('user.logged_in'));
        }

        return back()->withErrors(['password' => __('auth.failed')])->onlyInput('password');
    }
}
