<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParameterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'parameter' => $this->route('parameter'),
        ]);
    }

    public function rules()
    {
        return [
            'parameter' => 'required|min:3|max:10',
        ];
    }

    public function messages()
    {
        return [
            'parameter.required' => 'The parameter field is required.',
            'parameter.min' => 'The parameter must be at least 3 characters.',
            'parameter.max' => 'The parameter must not be more than 10 characters.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
