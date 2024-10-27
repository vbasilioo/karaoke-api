<?php

namespace App\Http\Requests\Show;

use App\Traits\BasicFormRequestValidation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreShowRequest extends FormRequest
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
            'name' => 'required|string',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'date_show' => 'required|date',
            'admin_id' => 'required',
            'type' => 'required|in:POP,RAP,TRAP,FUNK,SERTANEJO,MPB,PAGODE',
        ];
    }
}
