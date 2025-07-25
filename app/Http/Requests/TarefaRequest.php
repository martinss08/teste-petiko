<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TarefaRequest extends FormRequest
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
            'titulo' => ['required', 'min:3', 'max:255',
                Rule::unique('tarefas')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'));
                })
            ],
            'descricao' => ['nullable', 'max:230'],
            'status_id' => ['required', 'exists:status,id'],
            'data_tarefa' => ['required', 'date', 'after_or_equal:today'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.min'      => 'O título deve ter no mínimo 3 caracteres.',
            'titulo.max'      => 'O título não pode ter mais que 255 caracteres.',
            'titulo.unique' => 'Este usuário já possui uma tarefa com esse título.',

            'descricao.max'   => 'A descrição não pode ter mais que 230 caracteres.',

            'status_id.required' => 'Selecione um status.',
            'status_id.exists'   => 'Status inválido selecionado.',

            'data_tarefa.required' => 'A data da tarefa é obrigatória.',
            'data_tarefa.date' => 'Informe uma data válida.',
            'data_tarefa.after_or_equal' => 'A data deve ser hoje ou futura.',

            'user_id.required' => 'O campo de usuário é obrigatório.',
            'user_id.exists'   => 'O usuário selecionado é inválido.'
        ];
    }
}
