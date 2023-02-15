<?php

namespace App\Http\Requests;

use App\Models\BotAction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBotActionRequest extends FormRequest
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
            "id" => "required|integer",
            "name" => "required|string",
            "url" => "required|string",
            "img" => "nullable",
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
