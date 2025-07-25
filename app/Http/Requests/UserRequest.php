<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('id'); 

        return [
            'name' => ['required', 'min:3', 'max:100', 'unique:users,name,' . $userId],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email,' . $userId],
            'password' => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
            'tipo_user_id' => ['required', 'exists:tipos_user,id']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatorio.',
            'name.min' => 'O campo nome deve ter no minimo 3 caracteres.',
            'name.max' => 'O campo nome deve ter no maxino 100 caracteres.',
            'name.unique' => 'Já existe cadastro com esse nome.',

            'email.required' => 'O campo email é obrigatorio.',
            'email.email' => 'Você deve passar um email valido.',
            'email.unique' => 'Já existe cadastro com esse email.',

            'password.required' => 'O campo senha é obrigatorio.',
            'password.min' => 'O campo senha deve ter no minimo 6 caracteres.',

        ];
    }
}
