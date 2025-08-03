<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = MonthlyReport::with(['client', 'user']);

        // 사용자별 필터링
        if (Auth::user()->client_id) {
            $query->where('client_id', Auth::user()->client_id);
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

        $reports = $query->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->paginate(15);

        // 연도 목록
        $years = MonthlyReport::distinct()->pluck('year')->sort()->reverse();

        $gNum = "02";
        return view('monthly-reports.index', compact('reports', 'years', 'gNum'));
    }

    public function show($id)
    {
        $report = MonthlyReport::with(['client', 'user'])
            ->findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        return view('monthly-reports.show', compact('report'));
    }

    public function create()
    {
        // 현재 사용자의 클라이언트 정보
        $client = Auth::user()->client;

        if (!$client) {
            abort(403, '클라이언트 정보가 없습니다.');
        }

        return view('monthly-reports.create', compact('client'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2030',
            'month' => 'required|integer|min:1|max:12',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 중복 확인
        $existingReport = MonthlyReport::where('client_id', Auth::user()->client_id)
            ->where('year', $validated['year'])
            ->where('month', $validated['month'])
            ->first();

        if ($existingReport) {
            return back()->withErrors(['month' => '해당 연월의 보고서가 이미 존재합니다.']);
        }

        $report = MonthlyReport::create([
            'client_id' => Auth::user()->client_id,
            'user_id' => Auth::id(),
            'year' => $validated['year'],
            'month' => $validated['month'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => 'draft',
            'is_published' => false,
        ]);

        return redirect()->route('monthly-reports.show', $report)
            ->with('success', '월간보고서가 생성되었습니다.');
    }

    public function edit($id)
    {
        $report = MonthlyReport::with(['client'])
            ->findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        // 게시된 보고서는 수정 불가
        if ($report->is_published) {
            return back()->withErrors(['error' => '게시된 보고서는 수정할 수 없습니다.']);
        }

        return view('monthly-reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = MonthlyReport::findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        // 게시된 보고서는 수정 불가
        if ($report->is_published) {
            return back()->withErrors(['error' => '게시된 보고서는 수정할 수 없습니다.']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $report->update($validated);

        return redirect()->route('monthly-reports.show', $report)
            ->with('success', '월간보고서가 수정되었습니다.');
    }

    public function destroy($id)
    {
        $report = MonthlyReport::findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        // 게시된 보고서는 삭제 불가
        if ($report->is_published) {
            return back()->withErrors(['error' => '게시된 보고서는 삭제할 수 없습니다.']);
        }

        $report->delete();

        return redirect()->route('monthly-reports.index')
            ->with('success', '월간보고서가 삭제되었습니다.');
    }

    public function publish($id)
    {
        $report = MonthlyReport::findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        $report->publish();

        return back()->with('success', '월간보고서가 게시되었습니다.');
    }

    public function unpublish($id)
    {
        $report = MonthlyReport::findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        $report->unpublish();

        return back()->with('success', '월간보고서 게시가 취소되었습니다.');
    }

    public function print($id)
    {
        $report = MonthlyReport::with(['client', 'user'])
            ->findOrFail($id);

        // 권한 확인
        if (Auth::user()->client_id && $report->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        return view('monthly-reports.print', compact('report'));
    }
}
