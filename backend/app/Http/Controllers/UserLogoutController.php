<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserLogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->baseResponse(message: __('messages.auth.logout'));
    }
}
