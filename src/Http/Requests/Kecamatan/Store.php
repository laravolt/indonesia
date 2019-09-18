<?php

namespace Laravolt\Indonesia\Http\Requests\Kecamatan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravolt\Indonesia\Models\Kecamatan;

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
            'id' => ['required', 'max:8', Rule::unique((new Kecamatan())->getTable())->ignore($this->previous_id, 'id')],
            'name' => ['required'],
            'city_id' => ['required'],
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
