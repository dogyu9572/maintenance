<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('client')
            ->where('is_admin', false)
            ->orderBy('idx', 'desc');

        // 검색 조건
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('login_id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }        

        // 날짜 필터 - 시작일과 종료일이 모두 있을 때만 적용
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->where('created_at', '>=', $request->start_date)
                  ->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $perPage = $request->get('per_page', 20);
        $totalCount = $query->count();
        $accounts = $query->paginate($perPage);

        $gNum = "04";
        return view('admin.accounts.index', compact('accounts', 'totalCount', 'gNum'));
    }

    public function admins(Request $request)
    {
        $query = User::with('client')
            ->where('is_admin', true)
            ->orderBy('idx', 'desc');

        // 검색 조건
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('login_id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // 날짜 필터
        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $perPage = $request->get('per_page', 20);
        $totalCount = $query->count();
        $accounts = $query->paginate($perPage);

        $gNum = "04";
        return view('admin.accounts.admins', compact('accounts', 'totalCount', 'gNum'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $gNum = "04";
        return view('admin.accounts.create', compact('clients', 'gNum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'client_id' => 'required|exists:clients,idx',
            'position' => 'nullable|string|max:100',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date|after:contract_start',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean'
        ]);

        $user = User::create([
            'login_id' => $request->login_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'client_id' => $request->client_id,
            'position' => $request->position,
            'contract_start' => $request->contract_start,
            'contract_end' => $request->contract_end,
            'password' => bcrypt($request->password),
            'is_admin' => $request->is_admin ?? false,
            'is_active' => true
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', '계정이 성공적으로 생성되었습니다.');
    }

    public function edit($id)
    {
        $account = User::with('client')->findOrFail($id);
        $clients = Client::orderBy('name')->get();
        return view('admin.accounts.edit', compact('account', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'login_id' => 'required|string|max:255|unique:users,login_id,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'client_id' => 'required|exists:clients,idx',
            'position' => 'nullable|string|max:100',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date|after:contract_start',
            'password' => 'nullable|string|min:8',
            'is_admin' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = [
            'login_id' => $request->login_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'client_id' => $request->client_id,
            'position' => $request->position,
            'contract_start' => $request->contract_start,
            'contract_end' => $request->contract_end,
            'is_admin' => $request->is_admin ?? false,
            'is_active' => $request->is_active ?? true
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.accounts.index')
            ->with('success', '계정이 성공적으로 수정되었습니다.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,idx'
        ]);

        try {
            DB::beginTransaction();

            User::whereIn('idx', $request->ids)->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => '삭제 중 오류가 발생했습니다.'], 500);
        }
    }
}
