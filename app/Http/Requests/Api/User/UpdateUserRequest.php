<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiValidationRequest;

class UpdateUserRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|required|string|min:6|confirmed',
        ];
    }
}
