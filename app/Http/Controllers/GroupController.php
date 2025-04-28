<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $groups = Group::query();

        if ($request->has('with_users')) {
            $groups->with('users');
        }

        $groups = Group::whereHas(
            'users',
            fn($q) => $q->where('user_id', user()->getAuthIdentifier())
        )
            ->get();

        return $this->baseResponse(data: GroupResource::collection($groups), message: __('messages.group.all'));
    }

    /**
     * Show specific group
     */
    public function show(Request $request, Group $group): JsonResponse
    {
        if ($request->has('with_users')) {
            $group->load('users');
        }

        return $this->baseResponse(data: GroupResource::make($group), message: __('messages.group.show'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request): JsonResponse
    {
        $data = $request->validated();

        $group = Group::create($data);

        $group->users()->attach($data['members']);

        return $this->baseResponse(data: GroupResource::make($group), message: __('messages.group.create'), code: Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, Group $group)
    {
        $data = $request->validated();

        $group->update($data);

        if ($request->filled('members')) {
            $group->users()->sync($data['members']);
        }

        return $this->baseResponse(data: GroupResource::make($group), message: __('messages.group.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->users()->delete();

        $group->delete();

        return $this->baseResponse(message: __('messages.group.delete'));
    }
}
