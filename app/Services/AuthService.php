<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function authenticate($attributes): \Illuminate\Http\RedirectResponse
    {
        $user = $this->userRepository->findByEmail($attributes['email']);
        if (!isset($user->id)) {
            return redirect()->back()->with("error", "Không tìm thấy người dùng");
        }
        if (!Hash::check($attributes['password'], $user->password)) {
            return redirect()->back()->with("error","Sai mật khẩu");
        }
        Auth::loginUsingId($user->id);
        return to_route("index");
    }
}
