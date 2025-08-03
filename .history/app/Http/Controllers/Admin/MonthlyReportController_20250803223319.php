<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = MonthlyReport::with(['client', 'user']);

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

        $reports = $query->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->paginate(20);

        // 필터 옵션들
        $clients = Client::orderBy('name')->get();
        $years = MonthlyReport::distinct()->pluck('year')->sort()->reverse();

        $gNum = "02";
        return view('admin.monthly-reports.index', compact('reports', 'clients', 'years', 'gNum'));
    }

    public function show($id)
    {
        $report = MonthlyReport::with(['client', 'user'])
            ->findOrFail($id);

        return view('admin.monthly-reports.show', compact('report'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.monthly-reports.create', compact('clients', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,idx',
            'user_id' => 'required|exists:users,idx',
            'year' => 'required|integer|min:2020|max:2030',
            'month' => 'required|integer|min:1|max:12',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_published' => 'boolean',
        ]);

        // 중복 확인
        $existingReport = MonthlyReport::where('client_id', $validated['client_id'])
            ->where('year', $validated['year'])
            ->where('month', $validated['month'])
            ->first();

        if ($existingReport) {
            return back()->withErrors(['month' => '해당 연월의 보고서가 이미 존재합니다.']);
        }

        $report = MonthlyReport::create($validated);

        return redirect()->route('admin.monthly-reports.show', $report)
            ->with('success', '월간보고서가 생성되었습니다.');
    }

    public function edit($id)
    {
        $report = MonthlyReport::with(['client'])->findOrFail($id);

        $clients = Client::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.monthly-reports.edit', compact('report', 'clients', 'users'));
    }

    public function update(Request $request, $id)
    {
        $report = MonthlyReport::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,idx',
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

        return redirect()->route('admin.monthly-reports.index')
            ->with('success', '월간보고서가 삭제되었습니다.');
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
        $report = MonthlyReport::with(['client', 'user'])
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
        $clientStats = Client::withCount(['monthlyReports' => function($query) {
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
            'report_ids' => 'required|array',
            'report_ids.*' => 'exists:monthly_reports,idx',
        ]);

        MonthlyReport::whereIn('idx', $validated['report_ids'])
            ->update([
                'is_published' => true,
                'status' => 'published'
            ]);

        return back()->with('success', '선택된 보고서들이 게시되었습니다.');
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
