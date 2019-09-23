<?php

namespace Laravolt\Indonesia\Http\Requests\Provinsi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravolt\Indonesia\Models\Provinsi;

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
            'id' => ['required', 'max:2', Rule::unique((new Provinsi())->getTable())->ignore($this->previous_id, 'id')],
            'name' => ['required'],
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
