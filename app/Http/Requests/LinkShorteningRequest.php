<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkShorteningRequest extends FormRequest
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
            'url'           => 'required|url', // also can be only active_url
            'is_tracked'    => 'integer',
            'hash'          => 'alpha_dash|unique:links,hash',
        ];
    }

    public function messages()
    {
        return [
            'url.required'      => __('url.request.urlRequired'),
            'url.active_url'    => __('url.request.urlCheck'),
            'hash.alpha_dash'   => __('url.request.hashAlpha'),
            'hash.unique'       => __('url.request.hashUnique'),
        ];
    }
}
