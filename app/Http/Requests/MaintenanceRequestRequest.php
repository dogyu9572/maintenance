<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'maintenance_type_id' => 'required|exists:maintenance_types,idx',
            'status_id' => 'required|exists:request_statuses,idx',
            'assigned_user_id' => 'nullable|exists:users,idx',
            'priority' => 'required|in:low,medium,high,urgent',
        ];

        // 수정 시에만 추가 필드 검증
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = array_merge($rules, [
                'estimated_pm_hours' => 'nullable|integer|min:0',
                'estimated_design_hours' => 'nullable|integer|min:0',
                'estimated_publishing_hours' => 'nullable|integer|min:0',
                'estimated_development_hours' => 'nullable|integer|min:0',
                'actual_pm_hours' => 'nullable|integer|min:0',
                'actual_design_hours' => 'nullable|integer|min:0',
                'actual_publishing_hours' => 'nullable|integer|min:0',
                'actual_development_hours' => 'nullable|integer|min:0',
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => '제목을 입력해주세요.',
            'title.max' => '제목은 255자 이하여야 합니다.',
            'content.required' => '내용을 입력해주세요.',
            'maintenance_type_id.required' => '유지보수 유형을 선택해주세요.',
            'maintenance_type_id.exists' => '존재하지 않는 유지보수 유형입니다.',
            'status_id.required' => '상태를 선택해주세요.',
            'status_id.exists' => '존재하지 않는 상태입니다.',
            'assigned_user_id.exists' => '존재하지 않는 사용자입니다.',
            'priority.required' => '우선순위를 선택해주세요.',
            'priority.in' => '올바르지 않은 우선순위입니다.',
        ];
    }
}
