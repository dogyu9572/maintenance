<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private const GROUP_NUMBER = '04';
    private const DEFAULT_PER_PAGE = 20;

    public function __construct(
        private AccountService $accountService
    ) {}

    public function index(Request $request)
    {
        $isAdmin = $request->get('type') === 'admin';
        $query = $this->getUsersQuery($request, $isAdmin);
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $accounts = $query->paginate($perPage);

        $viewName = $isAdmin ? 'admin.accounts.admins' : 'admin.accounts.index';
        
        return view($viewName, [
            'accounts' => $accounts,
            'totalCount' => $accounts->total(),
            'gNum' => self::GROUP_NUMBER,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * 관리자 계정 목록 표시
     */
    public function admins(Request $request)
    {
        $query = $this->getUsersQuery($request, true); // 관리자만
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $accounts = $query->paginate($perPage);

        return view('admin.accounts.admins', [
            'accounts' => $accounts,
            'totalCount' => $accounts->total(),
            'gNum' => self::GROUP_NUMBER,
            'isAdmin' => true
        ]);
    }

    public function create()
    {
        return view('admin.accounts.create', [
            'gNum' => self::GROUP_NUMBER
        ]);
    }

    public function store(StoreAccountRequest $request)
    {
        try {
            $user = $this->accountService->createAccount($request->validated());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '계정이 성공적으로 생성되었습니다.',
                    'redirect' => route('admin.accounts.index')
                ]);
            }

            return redirect()->route('admin.accounts.index')
                ->with('success', '계정이 성공적으로 생성되었습니다.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '계정 생성 중 오류가 발생했습니다.',
                    'errors' => ['error' => ['계정 생성 중 오류가 발생했습니다.']]
                ], 422);
            }

            return back()->withInput()
                ->withErrors(['error' => '계정 생성 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $account = User::findOrFail($id);
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(UpdateAccountRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->accountService->updateAccount($user, $request->validated());

        return redirect()->route('admin.accounts.index')
            ->with('success', '계정이 성공적으로 수정되었습니다.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->accountService->deleteAccount($user);

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,idx'
        ]);

        try {
            $success = $this->accountService->bulkDeleteAccounts($request->ids);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => '삭제 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string|max:255'
        ]);

        $isDuplicate = $this->accountService->isLoginIdDuplicate($request->login_id);

        return response()->json([
            'available' => !$isDuplicate,
            'message' => $isDuplicate ? '이미 사용 중인 ID입니다.' : '사용 가능한 ID입니다.'
        ]);
    }

    /**
     * 사용자 쿼리 생성 (공통 로직)
     */
    private function getUsersQuery(Request $request, bool $isAdmin): \Illuminate\Database\Eloquent\Builder
    {
        $query = User::where('is_admin', $isAdmin)->orderBy('idx', 'desc');

        if ($request->filled('search')) {
            $this->applySearchFilter($query, $request->search);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $this->applyDateFilter($query, $request->start_date, $request->end_date);
        }

        return $query;
    }

    /**
     * 검색 필터 적용
     */
    private function applySearchFilter($query, string $search): void
    {
        $query->where(function($q) use ($search) {
            $q->where('login_id', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
        });
    }

    /**
     * 날짜 필터 적용
     */
    private function applyDateFilter($query, string $startDate, string $endDate): void
    {
        $query->where('created_at', '>=', $startDate)
              ->where('created_at', '<=', $endDate . ' 23:59:59');
    }
}
