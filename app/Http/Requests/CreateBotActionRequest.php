<?php

namespace App\Http\Requests;

use App\Models\BotAction;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBotActionRequest extends FormRequest
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
            "name" => "required|string",
            "img" => "required|mimes:jpg,jpeg,png",
            "type" => [
                'required',
                Rule::in([
                    BotAction::TYPE_ACTION,
                    BotAction::TYPE_MOVE
                ])
            ],
        ];
    }
}
