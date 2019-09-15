<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests;


class InventoryTradeRequest extends FormRequest
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
            'exchanger.survivor_id'     => 'required|integer',
            'exchanger.itens.*.ammount' => 'required|integer',
            'exchanger.itens.*.item'    => 'required|integer',
            'exchanger.itens.*.id'      => 'required|integer',
            'recipient.survivor_id'     => 'required|integer',
            'recipient.itens.*.ammount' => 'required|integer',
            'recipient.itens.*.id'      => 'required|integer',
            'recipient.itens.*.item'    => 'required|integer',
        ];
    }
}
