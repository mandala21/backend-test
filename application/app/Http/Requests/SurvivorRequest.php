<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurvivorRequest extends FormRequest
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
            'name'                  => 'required|max:150',
            'gender'                => 'required|integer',
            'age'                   => 'required|integer',
            'long'                  => 'required|numeric',
            'lat'                   => 'required|numeric',
            'inventory.*.item'      => 'required|integer',
            'inventory.*.ammount'   => 'required|integer',
        ];
    }
}
