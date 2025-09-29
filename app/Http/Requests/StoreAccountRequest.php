<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
        return [
            'login_id' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'member_type' => 'required|in:general,admin',
            'new_type' => 'nullable|in:new,renewal',
            'client_type' => 'nullable|string|max:100',
            'is_confirmed_client' => 'boolean',
            'monthly_report' => 'nullable|in:Y,N',
            'manager_name' => 'required|string|max:255',
            'manager_position' => 'nullable|string|max:100',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|email|max:255',
            'contact1_name' => 'nullable|string|max:255',
            'contact1_position' => 'nullable|string|max:100',
            'contact1_phone' => 'nullable|string|max:20',
            'contact1_email' => 'nullable|email|max:255',
            'contact2_name' => 'nullable|string|max:255',
            'contact2_position' => 'nullable|string|max:100',
            'contact2_phone' => 'nullable|string|max:20',
            'contact2_email' => 'nullable|email|max:255',
            'contact3_name' => 'nullable|string|max:255',
            'contact3_position' => 'nullable|string|max:100',
            'contact3_phone' => 'nullable|string|max:20',
            'contact3_email' => 'nullable|email|max:255',
            'domain' => 'nullable|string|max:255',
            'sub_domain' => 'nullable|string|max:255',
            'admin_url' => 'nullable|string|max:255',
            'admin_account' => 'nullable|string|max:255',
            'dev_language' => 'nullable|string|max:255',
            'db_type' => 'nullable|string|max:255',
            'domain_agency' => 'nullable|string|max:255',
            'server_agency' => 'nullable|string|max:255',
            'ssl_agency' => 'nullable|string|max:255',
            'ssl_expiry' => 'nullable|string|max:255',
            'ftp_host' => 'nullable|string|max:255',
            'ftp_id' => 'nullable|string|max:255',
            'ftp_password' => 'nullable|string|max:255',
            'ftp_id2' => 'nullable|string|max:255',
            'db_host' => 'nullable|string|max:255',
            'db_id' => 'nullable|string|max:255',
            'db_host2' => 'nullable|string|max:255',
            'db_id2' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'contract_start' => 'nullable|array',
            'contract_start.*' => 'nullable|string',
            'contract_end' => 'nullable|array',
            'contract_end.*' => 'nullable|string',
            'pm_hours' => 'nullable|array',
            'pm_hours.*' => 'nullable|numeric|min:0',
            'design_hours' => 'nullable|array',
            'design_hours.*' => 'nullable|numeric|min:0',
            'publish_hours' => 'nullable|array',
            'publish_hours.*' => 'nullable|numeric|min:0',
            'dev_hours' => 'nullable|array',
            'dev_hours.*' => 'nullable|numeric|min:0',
            'contract_files' => 'nullable|array',
            'contract_files.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'contract_unit' => 'nullable|string|max:10'
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
            'password.required' => '비밀번호는 필수입니다.',
            'password.min' => '비밀번호는 최소 8자 이상이어야 합니다.',
            'password_confirmation.same' => '비밀번호 확인이 일치하지 않습니다.',
            'member_type.required' => '회원 유형은 필수입니다.',
            'manager_name.required' => '담당자명은 필수입니다.',
        ];
    }
}
