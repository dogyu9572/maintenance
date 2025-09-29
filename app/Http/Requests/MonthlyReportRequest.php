<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\MonthlyReportService;
use Illuminate\Support\Facades\Auth;

class MonthlyReportRequest extends FormRequest
{
    protected $monthlyReportService;

    public function __construct(MonthlyReportService $monthlyReportService)
    {
        $this->monthlyReportService = $monthlyReportService;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];

        // 생성 시에만 연도/월 검증
        if ($this->isMethod('post')) {
            $rules['year'] = 'required|integer|min:2020|max:2030';
            $rules['month'] = 'required|integer|min:1|max:12';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'year.required' => '연도를 선택해주세요.',
            'year.integer' => '연도는 숫자여야 합니다.',
            'year.min' => '연도는 2020년 이상이어야 합니다.',
            'year.max' => '연도는 2030년 이하여야 합니다.',
            'month.required' => '월을 선택해주세요.',
            'month.integer' => '월은 숫자여야 합니다.',
            'month.min' => '월은 1월 이상이어야 합니다.',
            'month.max' => '월은 12월 이하여야 합니다.',
            'title.required' => '제목을 입력해주세요.',
            'title.max' => '제목은 255자 이하여야 합니다.',
            'content.required' => '내용을 입력해주세요.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->isMethod('post')) {
                // 중복 확인
                if ($this->monthlyReportService->checkDuplicateReport($this->year, $this->month)) {
                    $validator->errors()->add('month', '해당 연월의 보고서가 이미 존재합니다.');
                }
            }
        });
    }
}
