<?php

namespace App\Services;

use App\Models\MonthlyReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MonthlyReportService
{
    /**
     * 필터링된 월간보고서 목록 조회
     */
    public function getFilteredReports(array $filters = []): LengthAwarePaginator
    {
        $query = MonthlyReport::with(['client', 'user']);

        // 사용자별 필터링
        if (Auth::user()->client_id) {
            $query->byClient(Auth::user()->client_id);
        }

        // 연도별 필터링
        $year = $filters['year'] ?? now()->year;
        $query->byYear($year);

        // 월별 필터링
        if (isset($filters['month'])) {
            $query->byMonth($filters['month']);
        }

        // 상태별 필터링
        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        return $query->orderByYearMonth()->paginate(MonthlyReport::PER_PAGE);
    }

    /**
     * 연도 목록 조회
     */
    public function getAvailableYears(): Collection
    {
        return MonthlyReport::distinct()->pluck('year')->sort()->reverse();
    }

    /**
     * 보고서 생성
     */
    public function createReport(array $data): MonthlyReport
    {
        return MonthlyReport::create([
            'client_id' => Auth::user()->client_id,
            'user_id' => Auth::id(),
            'year' => $data['year'],
            'month' => $data['month'],
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => 'draft',
            'is_published' => false,
        ]);
    }

    /**
     * 보고서 수정
     */
    public function updateReport(MonthlyReport $report, array $data): bool
    {
        return (bool) $report->update($data);
    }

    /**
     * 보고서 게시
     */
    public function publishReport(MonthlyReport $report): bool
    {
        $report->publish();
        return true;
    }

    /**
     * 보고서 게시 취소
     */
    public function unpublishReport(MonthlyReport $report): bool
    {
        $report->unpublish();
        return true;
    }

    /**
     * 보고서 삭제
     */
    public function deleteReport(MonthlyReport $report): bool
    {
        return (bool) $report->delete();
    }

    /**
     * 보고서 권한 확인
     */
    public function checkReportPermission(MonthlyReport $report): bool
    {
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            return false;
        }
        return true;
    }

    /**
     * 보고서 수정 가능 여부 확인
     */
    public function canEditReport(MonthlyReport $report): bool
    {
        return $report->canEdit();
    }

    /**
     * 보고서 삭제 가능 여부 확인
     */
    public function canDeleteReport(MonthlyReport $report): bool
    {
        return $report->canDelete();
    }

    /**
     * 연월별 중복 보고서 확인
     */
    public function checkDuplicateReport(int $year, int $month): bool
    {
        return MonthlyReport::where('client_id', Auth::user()->client_id)
            ->where('year', $year)
            ->where('month', $month)
            ->exists();
    }
}
