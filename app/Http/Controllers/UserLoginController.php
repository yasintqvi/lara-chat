<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidLoginCredentialException;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserLoginRequest $request)
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            throw new InvalidLoginCredentialException;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->baseResponse(data: [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ], message: __('messages.auth.login'), code: Response::HTTP_CREATED);
    }
}
