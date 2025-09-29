<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = MonthlyReport::with(['user', 'client']);

        // 클라이언트별 필터링
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // 연도별 필터링
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        } else {
            $query->where('year', now()->year);
        }

        // 월별 필터링
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        // 상태별 필터링
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 게시 상태 필터링
        if ($request->filled('published')) {
            if ($request->published === 'true') {
                $query->published();
            } else {
                $query->where('is_published', false);
            }
        }

        $perPage = $request->get('per_page', 20);
        $reports = $query->orderBy('created_at', 'desc')
                        ->orderBy('idx', 'desc')
                        ->paginate($perPage);

        // 필터 옵션들
        $clients = User::where('is_admin', false)->orderBy('name')->get();
        $years = MonthlyReport::distinct()->pluck('year')->sort()->reverse();             

        $gNum = "02";
        return view('admin.monthly-reports.index', compact('reports', 'clients', 'years', 'gNum'));
    }

    public function show($id)
    {
        $report = MonthlyReport::with(['user'])
            ->findOrFail($id);

        $gNum = "02";
        return view('admin.monthly-reports.show', compact('report', 'gNum'));
    }

    public function create()
    {
        $clients = User::where('is_admin', false)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $gNum = "02";
        return view('admin.monthly-reports.create', compact('clients', 'users', 'gNum'));
    }

    public function store(Request $request)
    {
        // 디버깅: 요청 데이터 확인
        Log::info('MonthlyReport store 요청:', $request->all());
        
        try {
            Log::info('유효성 검사 시작');
            $validated = $request->validate([
                'user_id' => 'required|exists:users,idx',
                'client_id' => 'required|exists:users,idx',
                'title' => 'required|string|max:255',
                'report_date' => 'nullable|string',
                'work_start_date' => 'nullable|string',
                'work_end_date' => 'nullable|string',
                'project_name' => 'nullable|string',
                'manager_name' => 'nullable|string',
                'company_name' => 'nullable|string',
                'is_visible' => 'nullable|in:0,1',
                'special_notes' => 'nullable|string',
                'work_items' => 'nullable|array',
                'work_items.*.title' => 'nullable|string',
                'work_items.*.progress_rate' => 'nullable|string',
                'work_items.*.status' => 'nullable|string',
                'work_items.*.assignee' => 'nullable|string',
                'work_items.*.start_date' => 'nullable|string',
                'work_items.*.end_date' => 'nullable|string',
            ]);
            Log::info('유효성 검사 통과', $validated);

            // 연/월 계산 (report_date > work_start_date > today)
            $dateString = $validated['report_date'] ?? $validated['work_start_date'] ?? now()->format('Y-m-d');
            
            try {
                if (!empty($dateString)) {
                    $dateString = str_replace('.', '-', $dateString);
                    $reportDate = Carbon::parse($dateString);
                    $year = (int) $reportDate->format('Y');
                    $month = (int) $reportDate->format('n');
                } else {
                    // 기본값 설정
                    $year = (int) now()->format('Y');
                    $month = (int) now()->format('n');
                }
                Log::info('연/월 계산 완료', ['year' => $year, 'month' => $month]);
            } catch (\Exception $e) {
                Log::warning('날짜 파싱 오류, 기본값 사용', ['error' => $e->getMessage()]);
                $year = (int) now()->format('Y');
                $month = (int) now()->format('n');
            }

            // 중복 검사 제거 - 같은 연월에 여러 보고서 허용
            Log::info('중복 검사 건너뛰기 - 여러 보고서 허용');

            // 본문(content) 조립: 특이사항 + 업무항목 요약
            try {
                $contentParts = [];
                if (!empty($validated['special_notes'])) {
                    $contentParts[] = "[특이사항]\n" . $validated['special_notes'];
                }
                
                // work_items가 있고 실제 데이터가 있는 경우만 처리
                if (!empty($validated['work_items']) && is_array($validated['work_items'])) {
                    $lines = [];
                    foreach ($validated['work_items'] as $idx => $item) {
                        // 모든 필드가 null이면 건너뛰기
                        if (empty($item['title']) && empty($item['progress_rate']) && empty($item['status']) && 
                            empty($item['assignee']) && empty($item['start_date']) && empty($item['end_date'])) {
                            continue;
                        }
                        
                        $title = $item['title'] ?? '';
                        $progress = $item['progress_rate'] ?? '';
                        $status = $item['status'] ?? '';
                        $assignee = $item['assignee'] ?? '';
                        $start = $item['start_date'] ?? '';
                        $end = $item['end_date'] ?? '';
                        $lines[] = trim("- {$title} | 진행율: {$progress}% | 상태: {$status} | 담당: {$assignee} | 기간: {$start}~{$end}");
                    }
                    if ($lines) {
                        $contentParts[] = "[업무항목]\n" . implode("\n", $lines);
                    }
                }
                
                $content = implode("\n\n", $contentParts);
                Log::info('본문 조립 완료', ['content' => $content]);
            } catch (\Exception $e) {
                Log::warning('본문 조립 오류, 기본값 사용', ['error' => $e->getMessage()]);
                $content = $validated['title'] ?? '제목 없음';
            }

            // 날짜 처리 - 더 안전하게
            $workStartDate = null;
            $workEndDate = null;
            
            try {
                if (!empty($validated['work_start_date'])) {
                    $workStartDate = Carbon::parse(str_replace('.', '-', $validated['work_start_date']))->format('Y-m-d');
                }
                if (!empty($validated['work_end_date'])) {
                    $workEndDate = Carbon::parse(str_replace('.', '-', $validated['work_end_date']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::warning('날짜 파싱 오류', ['error' => $e->getMessage()]);
            }
            
            $reportData = [
                'user_id' => Auth::id(),
                'client_id' => $validated['client_id'],
                'year' => $year,
                'month' => $month,
                'title' => $validated['title'],
                'content' => $content,
                'status' => ($validated['is_visible'] ?? '1') === '1' ? 'published' : 'draft',
                'is_published' => ($validated['is_visible'] ?? '1') === '1',
                'work_start_date' => $workStartDate,
                'work_end_date' => $workEndDate,
                'project_name' => $validated['project_name'] ?? null,
                'manager_name' => $validated['manager_name'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
            ];
            
            Log::info('데이터베이스 저장 시작', $reportData);
            
            $report = MonthlyReport::create($reportData);
            
            Log::info('데이터베이스 저장 완료', ['report_id' => $report->idx]);

            Log::info('리다이렉트 시작');
            return redirect()->route('admin.monthly-reports.index')
                ->with('success', '월간보고서가 등록되었습니다.')
                ->with('show_alert', 'true');
                
        } catch (\Exception $e) {
            Log::error('MonthlyReport store 오류:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => '저장 중 오류가 발생했습니다: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $report = MonthlyReport::findOrFail($id);

        $users = User::orderBy('name')->get();

        return view('admin.monthly-reports.edit', compact('report', 'users'));
    }

    public function update(Request $request, $id)
    {
        $report = MonthlyReport::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,idx',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_published' => 'boolean',
        ]);

        $report->update($validated);

        return redirect()->route('admin.monthly-reports.show', $report)
            ->with('success', '월간보고서가 수정되었습니다.');
    }

    public function destroy($id)
    {
        $report = MonthlyReport::findOrFail($id);

        $report->delete();

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:monthly_reports,idx'
        ]);

        MonthlyReport::whereIn('idx', $validated['ids'])->delete();

        return response()->json(['success' => true]);
    }

    public function publish($id)
    {
        $report = MonthlyReport::findOrFail($id);

        $report->publish();

        return back()->with('success', '월간보고서가 게시되었습니다.');
    }

    public function unpublish($id)
    {
        $report = MonthlyReport::findOrFail($id);

        $report->unpublish();

        return back()->with('success', '월간보고서 게시가 취소되었습니다.');
    }

    public function print($id)
    {
        $report = MonthlyReport::with(['user'])
            ->findOrFail($id);

        return view('admin.monthly-reports.print', compact('report'));
    }

    public function statistics()
    {
        // 전체 통계
        $totalReports = MonthlyReport::count();
        $publishedReports = MonthlyReport::published()->count();
        $draftReports = MonthlyReport::where('is_published', false)->count();

        // 클라이언트별 통계
        $clientStats = User::where('is_admin', false)->withCount(['monthlyReports' => function($query) {
            $query->published();
        }])->get();

        // 연도별 통계
        $yearlyStats = MonthlyReport::selectRaw('
            year,
            COUNT(*) as total,
            COUNT(CASE WHEN is_published = 1 THEN 1 END) as published
        ')
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();

        return view('admin.monthly-reports.statistics', compact(
            'totalReports',
            'publishedReports',
            'draftReports',
            'clientStats',
            'yearlyStats'
        ));
    }

    public function bulkPublish(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:monthly_reports,idx',
        ]);

        MonthlyReport::whereIn('idx', $validated['ids'])
            ->update([
                'is_published' => true,
                'status' => 'published'
            ]);

        return response()->json(['success' => true]);
    }

    public function bulkUnpublish(Request $request)
    {
        $validated = $request->validate([
            'report_ids' => 'required|array',
            'report_ids.*' => 'exists:monthly_reports,idx',
        ]);

        MonthlyReport::whereIn('idx', $validated['report_ids'])
            ->update([
                'is_published' => false,
                'status' => 'draft'
            ]);

        return back()->with('success', '선택된 보고서들의 게시가 취소되었습니다.');
    }
}
