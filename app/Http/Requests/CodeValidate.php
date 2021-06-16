<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeValidate extends FormRequest
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
            'digitcode' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'store.required' => '参数错误'
        ];
    }
}
