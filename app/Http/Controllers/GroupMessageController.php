<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupMessage;
use App\Http\Resources\MessageResource;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Group $group): JsonResponse
    {
        $messages = $group->messages()->paginate($request->get('perpage'));

        return $this->baseResponse(data: MessageResource::collection($messages), message: __('messages.group.message.all'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupMessage $request, Group $group)
    {
        $message = $group->messages()->create([
            'message' => $request->validated('message'),
            'group_id' => "01jsmsa1rjvrfysk2cvhfvp8qh"
        ]);

        return $this->baseResponse(data: MessageResource::make($message), message: __('messages.group.message.create'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group, Message $message): JsonResponse
    {
        $message->delete();

        return $this->baseResponse(message: __('messages.group.message.delete'));
    }
}
