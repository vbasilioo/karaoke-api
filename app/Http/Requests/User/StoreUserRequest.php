<?php

namespace App\Http\Requests\User;

use App\Traits\BasicFormRequestValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use BasicFormRequestValidation;

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
            'username' => 'required|unique:users,username',
            'telephone' => 'required|unique:users',
            'table' => 'required|unique:users',
            'code_access' => 'required|exists:shows,code_access'
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'nome de usuário',
            'telephone' => 'telefone',
            'table' => 'mesa',
            'code_access' => 'código de acesso'
        ];
    }

    public function messages(): array{
        return [
            'username.required' => 'O :attribute é obrigatório.',
            'username.unique' => 'O :attribute já está em uso.',
            'telephone.required' => 'O :attribute é obrigatório.',
            'telephone.unique' => 'O :attribute já está em uso.',
            'table.required' => 'A :attribute é obrigatória.',
            'table.unique' => 'A :attribute já está em uso.',
            'code_access.required' => 'Verifique novamente o :attribute.',
            'code_access.exists' => 'O código de acesso informado não existe.'
        ];
    }
}
