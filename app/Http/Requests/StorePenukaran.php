<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenukaran extends FormRequest
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
            'total_rupiah'                      => 'required|numeric',
            'jenis_tukar'                       => 'required',
            'kurs_penukaran'                    => 'required|array|min:1',
            'kurs_penukaran.*.prefix'           => 'required|size:3',
            'kurs_penukaran.*.kurs_id'          => 'required|numeric',
            'kurs_penukaran.*.rate.jual'      => 'required|numeric',
            'kurs_penukaran.*.rate.beli'      => 'required|numeric',
            'kurs_penukaran.*.rupiah'           => 'required|numeric',
        ];
        //return $rules;
    }
}
