<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

if (!function_exists('user')) {
    function user(): ?Authenticatable
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::user();
    }
}
