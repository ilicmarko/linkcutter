<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateLink extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'   => 'required|active_url',
            'email' => 'email',
        ];
    }

    /**
     * Prevent Laravel from redirecting, because this is an API
     * Status code: https://httpstatuses.com/422
     */
    protected function failedValidation(Validator $validator) {
        $response = array();
        $response['success'] = false;
        $response['errors'] = $validator->errors();

        throw new HttpResponseException(response()->json($response, 422));
    }
}
