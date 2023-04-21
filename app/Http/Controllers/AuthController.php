<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    )
    {
    }

    public function login(): View
    {
        return view("login");
    }

    public function authenticate(Request $request): RedirectResponse|JsonResponse|int
    {
        return $this->authService->authenticate($request->input());
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->back();
    }
}
