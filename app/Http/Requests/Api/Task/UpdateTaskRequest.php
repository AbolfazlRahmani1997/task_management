<?php

namespace App\Http\Requests\Api\Task;

use App\Http\Requests\Api\ApiValidationRequest;

class UpdateTaskRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'due_date' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|in:pending,completed',
        ];
    }
}
