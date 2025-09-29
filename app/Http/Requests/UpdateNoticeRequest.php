<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_important' => 'boolean',
            'is_published' => 'boolean',
            'attachments.*' => 'nullable|file|max:20480',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => '제목은 필수입니다.',
            'title.max' => '제목은 최대 255자까지 입력 가능합니다.',
            'content.required' => '내용은 필수입니다.',
            'attachments.*.file' => '올바른 파일을 선택해주세요.',
            'attachments.*.max' => '파일 크기는 최대 20MB까지 가능합니다.',
        ];
    }
}
