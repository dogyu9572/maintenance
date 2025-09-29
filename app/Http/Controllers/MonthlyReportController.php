<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use App\Http\Requests\MonthlyReportRequest;
use App\Services\MonthlyReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    protected $monthlyReportService;

    public function __construct(MonthlyReportService $monthlyReportService)
    {
        $this->monthlyReportService = $monthlyReportService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['year', 'month', 'status']);
        
        $reports = $this->monthlyReportService->getFilteredReports($filters);
        $years = $this->monthlyReportService->getAvailableYears();

        return view('monthly-reports.index', compact('reports', 'years'));
    }

    public function show($id)
    {
        $report = MonthlyReport::with(['client', 'user'])->findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        return view('monthly-reports.show', compact('report'));
    }

    public function create()
    {
        $client = Auth::user()->client;

        if (!$client) {
            abort(403, '클라이언트 정보가 없습니다.');
        }

        return view('monthly-reports.create', compact('client'));
    }

    public function store(MonthlyReportRequest $request)
    {
        $validated = $request->validated();

        $report = $this->monthlyReportService->createReport($validated);

        return redirect()->route('monthly-reports.show', $report)
            ->with('success', '월간보고서가 생성되었습니다.');
    }

    public function edit($id)
    {
        $report = MonthlyReport::with(['client'])->findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        if (!$this->monthlyReportService->canEditReport($report)) {
            return back()->withErrors(['error' => '게시된 보고서는 수정할 수 없습니다.']);
        }

        return view('monthly-reports.edit', compact('report'));
    }

    public function update(MonthlyReportRequest $request, $id)
    {
        $report = MonthlyReport::findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        if (!$this->monthlyReportService->canEditReport($report)) {
            return back()->withErrors(['error' => '게시된 보고서는 수정할 수 없습니다.']);
        }

        $validated = $request->validated();
        $this->monthlyReportService->updateReport($report, $validated);

        return redirect()->route('monthly-reports.show', $report)
            ->with('success', '월간보고서가 수정되었습니다.');
    }

    public function destroy($id)
    {
        $report = MonthlyReport::findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        if (!$this->monthlyReportService->canDeleteReport($report)) {
            return back()->withErrors(['error' => '게시된 보고서는 삭제할 수 없습니다.']);
        }

        $this->monthlyReportService->deleteReport($report);

        return redirect()->route('monthly-reports.index')
            ->with('success', '월간보고서가 삭제되었습니다.');
    }

    public function publish($id)
    {
        $report = MonthlyReport::findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        $this->monthlyReportService->publishReport($report);

        return back()->with('success', '월간보고서가 게시되었습니다.');
    }

    public function unpublish($id)
    {
        $report = MonthlyReport::findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        $this->monthlyReportService->unpublishReport($report);

        return back()->with('success', '월간보고서 게시가 취소되었습니다.');
    }

    public function print($id)
    {
        $report = MonthlyReport::with(['client', 'user'])->findOrFail($id);
        
        if (!$this->monthlyReportService->checkReportPermission($report)) {
            abort(403);
        }

        return view('monthly-reports.print', compact('report'));
    }
}
