<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors(),
        ], 422));
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => 'required|unique:users',
            'nome' => 'required',
            'data_nascimento' => 'required'
        ];
    }

    public function messages(): array 
    {
        return [
            'cpf.required' => 'Campo cpf é obrigatório!',
            'cpf.unique' => 'O cpf já está cadastrado!',
            'nome.required' => 'Campo nome é obrigatório!',
            'data_nascimento.required' => 'Campo data de nascimento é obrigatório!'
        ];
    }

}