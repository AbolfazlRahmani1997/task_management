<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiValidationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $errors
            ], 422)
        );
    }
}
