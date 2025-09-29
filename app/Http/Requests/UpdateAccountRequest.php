<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $userId = $this->route('id');
        
        return [
            'login_id' => 'required|string|max:255|unique:users,login_id,' . $userId,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date|after:contract_start',
            'password' => 'nullable|string|min:8',
            'is_admin' => 'boolean',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'login_id.required' => '로그인 ID는 필수입니다.',
            'login_id.unique' => '이미 사용 중인 로그인 ID입니다.',
            'name.required' => '이름은 필수입니다.',
            'email.required' => '이메일은 필수입니다.',
            'email.email' => '올바른 이메일 형식이 아닙니다.',
            'email.unique' => '이미 사용 중인 이메일입니다.',
            'password.min' => '비밀번호는 최소 8자 이상이어야 합니다.',
            'contract_end.after' => '계약 종료일은 계약 시작일 이후여야 합니다.',
        ];
    }
}
