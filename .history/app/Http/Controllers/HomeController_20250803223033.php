<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 최근 유지보수 요청
        $recentRequests = MaintenanceRequest::with(['status', 'maintenanceType', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 상태별 통계
        $statusStats = RequestStatus::withCount('maintenanceRequests')->get();

        $gNum = "00";
        return view('home', compact('recentRequests', 'statusStats', 'gNum'));
    }

    public function adminDashboard()
    {
        // 관리자 권한 확인
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home');
        }

        // 모든 유지보수 요청
        $allRequests = MaintenanceRequest::with(['status', 'maintenanceType', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 상태별 통계
        $statusStats = RequestStatus::withCount('maintenanceRequests')->get();

        return view('admin.dashboard', compact('allRequests', 'statusStats'));
    }

    public function adminPreferences()
    {
        // 관리자 권한 확인
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home');
        }

        return view('admin.preferences');
    }
}
