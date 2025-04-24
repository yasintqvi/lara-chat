<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserRegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserRegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->baseResponse(data: [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ], message: __('messages.auth.register'), code: Response::HTTP_CREATED);
    }
}
