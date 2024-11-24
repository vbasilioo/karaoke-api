<?php

namespace App\Http\Requests\Show;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'name' => 'required|string',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'date_show' => 'required|date',
            'admin_id' => 'required',
            'type' => 'required|in:POP,RAP,TRAP,FUNK,SERTANEJO,MPB,PAGODE',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'id' => $this->input('id'),
        ]);
    }
}
