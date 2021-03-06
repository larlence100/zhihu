<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
            'title' => 'required|min:6',
            'body' => 'required|min:20'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能低于6个字符',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能低于20个字符',
        ];

    }
}
