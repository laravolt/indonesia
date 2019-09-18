<?php

namespace Laravolt\Indonesia\Http\Requests\Kelurahan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravolt\Indonesia\Models\Kelurahan;

class Store extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'max:10', Rule::unique((new Kelurahan())->getTable())->ignore($this->previous_id, 'id')],
            'name' => ['required'],
            'district_id' => ['required'],
            'meta' => 'nullable',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
