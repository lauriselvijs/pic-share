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
        $this->authService = $authService;
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
        $user = $this->authService->store($request->validated());

        auth()->login($user);

        return redirect()->route('verification.notice')->with('message',  __('user.created'));
    }

    /**
     * User logout
     */
    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();

        $this->authService->invalidate($request->session());

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
        if ($this->authService->authenticate($request->session(), $request->validated(), $request->has('remember'))) {
            return redirect()->route('posts.index')->with('message',  __('user.logged_in'));
        }

        return back()->withErrors(['password' => __('auth.failed')])->onlyInput('password');
    }
}
