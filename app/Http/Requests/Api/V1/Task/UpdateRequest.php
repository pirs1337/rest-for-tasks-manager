<?php

namespace App\Http\Requests\Api\V1\Task;

use App\Http\Requests\Api\V1\ApiRequest;

class UpdateRequest extends StoreRequest
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
            'title' => ['required', 'max:255', 'min:1', 'string'],
            'body' => ['required', 'min:1', 'string'],
            'status' => ['required', 'max:255', 'in:Активный,Отложенный,Завершенный']
        ];
    }
}
