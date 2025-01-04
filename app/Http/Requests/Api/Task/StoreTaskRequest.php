<?php

namespace App\Http\Requests\Api\Task;

use App\Http\Requests\Api\ApiValidationRequest;

class StoreTaskRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|integer|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,completed',
        ];
    }
}
