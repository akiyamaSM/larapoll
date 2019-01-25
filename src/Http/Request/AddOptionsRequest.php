<?php

namespace Inani\Larapoll\Http\Request;



use Illuminate\Foundation\Http\FormRequest;

class AddOptionsRequest extends FormRequest
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
            'options.*' => 'present|required'
        ];
    }

    public function messages()
    {
        return [
            'options.*.required' => 'Options Field Should not be empty',
        ];
    }
}
