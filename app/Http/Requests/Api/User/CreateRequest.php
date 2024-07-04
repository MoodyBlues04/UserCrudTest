<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\CreateRequest as CreateRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class CreateRequest extends FormRequest implements CreateRequestInterface
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
            'name' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'bio' => 'nullable|string',
        ];
    }

    public function getDataToCreate(): array
    {
        return [
            'name' => $this->name,
            'bio' => $this->bio,
            'password' => Hash::make($this->password),
        ];
    }
}
