<?php

namespace App\Http\Requests\Players;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'nationality' => ['required', 'string', 'max:20'],
            'age' => ['required', 'integer'],
            'position' => ['required', 'string', 'max:30'],
            'shirt_number' => ['required', 'integer'],
            'photo' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'team_id' => [
                'required',
                'integer',
                'exists:teams,id',
                Rule::unique('players')->where(function ($query) {
                    return $query->where('shirt_number', $this->get('shirt_number'));
                }),
            ],
        ];
    }

    public function validated($key = null, $default = null): Player
    {
        $data = parent::validated($key, $default);
        unset($data['photo']);

        return new Player($data);
    }

    public function messages(): array
    {
        return [
            'team_id.unique' => 'The shirt number is already registered for this team.',
        ];
    }
}
