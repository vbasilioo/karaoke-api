<?php

namespace App\Http\Requests\Show;

use Illuminate\Foundation\Http\FormRequest;

class CodeAccessShowRequest extends FormRequest
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
    public function rules(): array{
        return [
            'code_access' => 'required',
        ];
    }

    public function prepareForValidation(): void{
        $this->merge([
            'code_access' => $this->route('code_access')
        ]);
    }
}
