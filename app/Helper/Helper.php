<?php

use App\Untils\Principal;
use Illuminate\Support\Facades\Auth;


if (!function_exists('principal')) {
    function principal(): Principal
    {
        $user = Auth::user();
        return new Principal(
            id: $user->id ?? null,
            name: $user->name ?? null,
            type: $user->type ?? null,
            email: $user->email ?? null,
            auth: Auth::check()
        );
    }
}
