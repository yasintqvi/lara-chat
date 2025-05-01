<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidLoginCredentialException;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            return $this->baseResponse(message: __('messages.auth.invalid_login'), code: Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->baseResponse(data: [
            'user' => UserResource::make($user),
            'token' => $token
        ], message: __('messages.auth.login'), code: Response::HTTP_CREATED);
    }
}
