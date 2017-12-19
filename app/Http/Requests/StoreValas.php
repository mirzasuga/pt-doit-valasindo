<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Valas;

class StoreValas extends FormRequest
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
            'prefix'=> 'required|size:3',
            'nama_valas'  => 'required',
            'stok'  => 'required|numeric',
        ];
    }
    public function messages() {
        return [
            'prefix.required'   => 'Currencies Tidak boleh kosong',
            'prefix.size'       => 'Currencies tidak boleh lebih dari 3 karakter',
            'nama_valas.required'     => 'Nama valas tidak boleh kosong',
            'stok.required'     => 'Stok tidak boleh kosong',
            'stok.numeric'      => 'Stok hanya boleh berisi angka'
        ];
    }
}
