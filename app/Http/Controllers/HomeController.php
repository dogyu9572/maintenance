<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    const G_NUM_HOME = '00';
    const G_NUM_PREFERENCES = '05';

    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $recentRequests = $this->homeService->getRecentRequests();
        $statistics = $this->homeService->getMaintenanceStatistics();

        return view('home', compact('recentRequests', 'statistics'));
    }

    public function adminDashboard(Request $request)
    {
        // 관리자 권한 확인
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home');
        }

        $currentStatus = $request->get('status', 'all');

        $filteredRequests = $this->homeService->getFilteredRequests($currentStatus);
        $allRequests = $this->homeService->getFilteredRequests('all');
        $totalRequestsCount = $this->homeService->getTotalRequestsCount();
        $clients = $this->homeService->getClientsWithRequestCount();
        $recentNotices = $this->homeService->getRecentNotices();
        $statistics = $this->homeService->getStatusCountsArray();

        // 최근 알림내역 (실제 구현에서는 Notification 모델 사용)
        $recentNotifications = $this->getRecentNotifications();

        return view('admin.dashboard', compact(
            'filteredRequests', 
            'allRequests',
            'currentStatus',
            'totalRequestsCount',
            'clients',
            'recentNotifications',
            'recentNotices',
            'statistics'
        ));
    }

    public function adminPreferences()
    {
        // 관리자 권한 확인
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home');
        }

        return view('admin.preferences');
    }

    /**
     * 최근 알림내역 조회 (임시 구현)
     * TODO: 실제 Notification 모델로 대체 필요
     */
    private function getRecentNotifications(): array
    {
        return [
            (object) [
                'message' => '2024-08-16에 허지선님이 요청주신 내역이 접수되었습니다.',
                'created_at' => now()->subDays(1)
            ],
            (object) [
                'message' => '2024-08-15에 김철수님이 요청주신 내역이 접수되었습니다.',
                'created_at' => now()->subDays(2)
            ]
        ];
    }
}
