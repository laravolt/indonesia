<?php

namespace Laravolt\Indonesia\Http\Requests\Kabupate;

use Illuminate\Foundation\Http\FormRequest;

class Update extends Store
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'max:2'],
            'name' => ['required'],
            'district_id' => ['required'],
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
