<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Manager;
use App\Models\Contract;
use App\Models\ServerInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with(['managers', 'contracts', 'serverInfo'])
            ->orderBy('idx', 'desc');

        // 검색 조건
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // 타입 필터
        if ($request->filled('client_type')) {
            $query->where('client_type', $request->client_type);
        }

        // 활성화 상태 필터
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $perPage = $request->get('per_page', 20);
        $clients = $query->paginate($perPage);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // 기본 정보
            'name' => 'required|string|max:255',
            'client_type' => 'required|in:association,company,individual',
            'is_manpower_check' => 'boolean',
            'monthly_report_enabled' => 'boolean',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date|after:contract_start',
            'website_url' => 'nullable|url|max:255',

            // 계정 정보
            'login_id' => 'required|string|max:255|unique:users,login_id',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',

            // 담당자 정보
            'managers' => 'array',
            'managers.*.name' => 'required|string|max:255',
            'managers.*.position' => 'nullable|string|max:100',
            'managers.*.phone' => 'nullable|string|max:20',
            'managers.*.email' => 'nullable|email|max:255',
            'managers.*.role' => 'required|in:primary,secondary',

            // 계약 정보
            'contracts' => 'array',
            'contracts.*.contract_start' => 'required|date',
            'contracts.*.contract_end' => 'required|date|after:contracts.*.contract_start',
            'contracts.*.pm_hours' => 'required|numeric|min:0',
            'contracts.*.design_hours' => 'required|numeric|min:0',
            'contracts.*.publishing_hours' => 'required|numeric|min:0',
            'contracts.*.development_hours' => 'required|numeric|min:0',
            'contracts.*.contract_file' => 'nullable|file|mimes:pdf,doc,docx,hwp|max:10240',

            // 서버 정보
            'server_info.domain' => 'nullable|string|max:255',
            'server_info.sub_domain' => 'nullable|string|max:255',
            'server_info.admin_url' => 'nullable|url|max:255',
            'server_info.admin_account' => 'nullable|string|max:255',
            'server_info.development_language' => 'nullable|string|max:255',
            'server_info.database_type' => 'nullable|string|max:255',
            'server_info.domain_provider' => 'nullable|string|max:255',
            'server_info.server_provider' => 'nullable|string|max:255',
            'server_info.ssl_provider' => 'nullable|string|max:255',
            'server_info.ssl_expiry_date' => 'nullable|date',
            'server_info.ftp_host' => 'nullable|string|max:255',
            'server_info.ftp_id' => 'nullable|string|max:255',
            'server_info.ftp_password' => 'nullable|string|max:255',
            'server_info.db_host' => 'nullable|string|max:255',
            'server_info.db_id' => 'nullable|string|max:255',
            'server_info.db_password' => 'nullable|string|max:255',
            'server_info.notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // 클라이언트 생성
            $client = Client::create([
                'name' => $request->name,
                'client_type' => $request->client_type,
                'is_manpower_check' => $request->is_manpower_check ?? false,
                'monthly_report_enabled' => $request->monthly_report_enabled ?? true,
                'contract_start' => $request->contract_start,
                'contract_end' => $request->contract_end,
                'website_url' => $request->website_url,
                'is_active' => true,
            ]);

            // 관리자 계정 생성
            $user = User::create([
                'login_id' => $request->login_id,
                'name' => $request->name,
                'username' => $request->login_id,
                'email' => $request->managers[0]['email'] ?? null,
                'phone' => $request->managers[0]['phone'] ?? null,
                'position' => $request->managers[0]['position'] ?? null,
                'client_id' => $client->idx,
                'password' => Hash::make($request->password),
                'is_admin' => false,
                'is_active' => true,
            ]);

            // 담당자 정보 저장
            if ($request->has('managers')) {
                foreach ($request->managers as $index => $managerData) {
                    if (!empty($managerData['name'])) {
                        Manager::create([
                            'client_id' => $client->idx,
                            'name' => $managerData['name'],
                            'position' => $managerData['position'] ?? null,
                            'phone' => $managerData['phone'] ?? null,
                            'email' => $managerData['email'] ?? null,
                            'role' => $managerData['role'],
                            'manager_order' => $index + 1,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            // 계약 정보 저장
            if ($request->has('contracts')) {
                foreach ($request->contracts as $index => $contractData) {
                    $contractFile = null;
                    $contractFileName = null;

                    if (isset($contractData['contract_file']) && $contractData['contract_file']->isValid()) {
                        $file = $contractData['contract_file'];
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('contracts', $fileName, 'public');
                        $contractFile = $filePath;
                        $contractFileName = $file->getClientOriginalName();
                    }

                    Contract::create([
                        'client_id' => $client->idx,
                        'contract_start' => $contractData['contract_start'],
                        'contract_end' => $contractData['contract_end'],
                        'pm_hours' => $contractData['pm_hours'],
                        'design_hours' => $contractData['design_hours'],
                        'publishing_hours' => $contractData['publishing_hours'],
                        'development_hours' => $contractData['development_hours'],
                        'contract_file_path' => $contractFile,
                        'contract_file_name' => $contractFileName,
                        'contract_order' => $index + 1,
                        'is_active' => true,
                    ]);
                }
            }

            // 서버 정보 저장
            if ($request->has('server_info')) {
                $serverData = $request->server_info;
                if (!empty(array_filter($serverData))) {
                    ServerInfo::create([
                        'client_id' => $client->idx,
                        'domain' => $serverData['domain'] ?? null,
                        'sub_domain' => $serverData['sub_domain'] ?? null,
                        'admin_url' => $serverData['admin_url'] ?? null,
                        'admin_account' => $serverData['admin_account'] ?? null,
                        'development_language' => $serverData['development_language'] ?? null,
                        'database_type' => $serverData['database_type'] ?? null,
                        'domain_provider' => $serverData['domain_provider'] ?? null,
                        'server_provider' => $serverData['server_provider'] ?? null,
                        'ssl_provider' => $serverData['ssl_provider'] ?? null,
                        'ssl_expiry_date' => $serverData['ssl_expiry_date'] ?? null,
                        'ftp_host' => $serverData['ftp_host'] ?? null,
                        'ftp_id' => $serverData['ftp_id'] ?? null,
                        'ftp_password' => $serverData['ftp_password'] ?? null,
                        'db_host' => $serverData['db_host'] ?? null,
                        'db_id' => $serverData['db_id'] ?? null,
                        'db_password' => $serverData['db_password'] ?? null,
                        'notes' => $serverData['notes'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.clients.index')
                ->with('success', '클라이언트가 성공적으로 생성되었습니다.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => '클라이언트 생성 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $client = Client::with(['managers', 'contracts', 'serverInfo', 'users'])
            ->findOrFail($id);

        return view('admin.clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::with(['managers', 'contracts', 'serverInfo'])
            ->findOrFail($id);

        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            // 기본 정보
            'name' => 'required|string|max:255',
            'client_type' => 'required|in:association,company,individual',
            'is_manpower_check' => 'boolean',
            'monthly_report_enabled' => 'boolean',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date|after:contract_start',
            'website_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',

            // 담당자 정보
            'managers' => 'array',
            'managers.*.name' => 'required|string|max:255',
            'managers.*.position' => 'nullable|string|max:100',
            'managers.*.phone' => 'nullable|string|max:20',
            'managers.*.email' => 'nullable|email|max:255',
            'managers.*.role' => 'required|in:primary,secondary',

            // 계약 정보
            'contracts' => 'array',
            'contracts.*.contract_start' => 'required|date',
            'contracts.*.contract_end' => 'required|date|after:contracts.*.contract_start',
            'contracts.*.pm_hours' => 'required|numeric|min:0',
            'contracts.*.design_hours' => 'required|numeric|min:0',
            'contracts.*.publishing_hours' => 'required|numeric|min:0',
            'contracts.*.development_hours' => 'required|numeric|min:0',
            'contracts.*.contract_file' => 'nullable|file|mimes:pdf,doc,docx,hwp|max:10240',

            // 서버 정보
            'server_info.domain' => 'nullable|string|max:255',
            'server_info.sub_domain' => 'nullable|string|max:255',
            'server_info.admin_url' => 'nullable|url|max:255',
            'server_info.admin_account' => 'nullable|string|max:255',
            'server_info.development_language' => 'nullable|string|max:255',
            'server_info.database_type' => 'nullable|string|max:255',
            'server_info.domain_provider' => 'nullable|string|max:255',
            'server_info.server_provider' => 'nullable|string|max:255',
            'server_info.ssl_provider' => 'nullable|string|max:255',
            'server_info.ssl_expiry_date' => 'nullable|date',
            'server_info.ftp_host' => 'nullable|string|max:255',
            'server_info.ftp_id' => 'nullable|string|max:255',
            'server_info.ftp_password' => 'nullable|string|max:255',
            'server_info.db_host' => 'nullable|string|max:255',
            'server_info.db_id' => 'nullable|string|max:255',
            'server_info.db_password' => 'nullable|string|max:255',
            'server_info.notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // 클라이언트 정보 업데이트
            $client->update([
                'name' => $request->name,
                'client_type' => $request->client_type,
                'is_manpower_check' => $request->is_manpower_check ?? false,
                'monthly_report_enabled' => $request->monthly_report_enabled ?? true,
                'contract_start' => $request->contract_start,
                'contract_end' => $request->contract_end,
                'website_url' => $request->website_url,
                'is_active' => $request->is_active ?? true,
            ]);

            // 담당자 정보 업데이트
            if ($request->has('managers')) {
                // 기존 담당자 삭제
                $client->managers()->delete();

                // 새로운 담당자 추가
                foreach ($request->managers as $index => $managerData) {
                    if (!empty($managerData['name'])) {
                        Manager::create([
                            'client_id' => $client->idx,
                            'name' => $managerData['name'],
                            'position' => $managerData['position'] ?? null,
                            'phone' => $managerData['phone'] ?? null,
                            'email' => $managerData['email'] ?? null,
                            'role' => $managerData['role'],
                            'manager_order' => $index + 1,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            // 계약 정보 업데이트
            if ($request->has('contracts')) {
                // 기존 계약 삭제
                $client->contracts()->delete();

                // 새로운 계약 추가
                foreach ($request->contracts as $index => $contractData) {
                    $contractFile = null;
                    $contractFileName = null;

                    if (isset($contractData['contract_file']) && $contractData['contract_file']->isValid()) {
                        $file = $contractData['contract_file'];
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('contracts', $fileName, 'public');
                        $contractFile = $filePath;
                        $contractFileName = $file->getClientOriginalName();
                    }

                    Contract::create([
                        'client_id' => $client->idx,
                        'contract_start' => $contractData['contract_start'],
                        'contract_end' => $contractData['contract_end'],
                        'pm_hours' => $contractData['pm_hours'],
                        'design_hours' => $contractData['design_hours'],
                        'publishing_hours' => $contractData['publishing_hours'],
                        'development_hours' => $contractData['development_hours'],
                        'contract_file_path' => $contractFile,
                        'contract_file_name' => $contractFileName,
                        'contract_order' => $index + 1,
                        'is_active' => true,
                    ]);
                }
            }

            // 서버 정보 업데이트
            if ($request->has('server_info')) {
                $serverData = $request->server_info;

                if ($client->serverInfo) {
                    $client->serverInfo->update([
                        'domain' => $serverData['domain'] ?? null,
                        'sub_domain' => $serverData['sub_domain'] ?? null,
                        'admin_url' => $serverData['admin_url'] ?? null,
                        'admin_account' => $serverData['admin_account'] ?? null,
                        'development_language' => $serverData['development_language'] ?? null,
                        'database_type' => $serverData['database_type'] ?? null,
                        'domain_provider' => $serverData['domain_provider'] ?? null,
                        'server_provider' => $serverData['server_provider'] ?? null,
                        'ssl_provider' => $serverData['ssl_provider'] ?? null,
                        'ssl_expiry_date' => $serverData['ssl_expiry_date'] ?? null,
                        'ftp_host' => $serverData['ftp_host'] ?? null,
                        'ftp_id' => $serverData['ftp_id'] ?? null,
                        'ftp_password' => $serverData['ftp_password'] ?? null,
                        'db_host' => $serverData['db_host'] ?? null,
                        'db_id' => $serverData['db_id'] ?? null,
                        'db_password' => $serverData['db_password'] ?? null,
                        'notes' => $serverData['notes'] ?? null,
                    ]);
                } else {
                    ServerInfo::create([
                        'client_id' => $client->idx,
                        'domain' => $serverData['domain'] ?? null,
                        'sub_domain' => $serverData['sub_domain'] ?? null,
                        'admin_url' => $serverData['admin_url'] ?? null,
                        'admin_account' => $serverData['admin_account'] ?? null,
                        'development_language' => $serverData['development_language'] ?? null,
                        'database_type' => $serverData['database_type'] ?? null,
                        'domain_provider' => $serverData['domain_provider'] ?? null,
                        'server_provider' => $serverData['server_provider'] ?? null,
                        'ssl_provider' => $serverData['ssl_provider'] ?? null,
                        'ssl_expiry_date' => $serverData['ssl_expiry_date'] ?? null,
                        'ftp_host' => $serverData['ftp_host'] ?? null,
                        'ftp_id' => $serverData['ftp_id'] ?? null,
                        'ftp_password' => $serverData['ftp_password'] ?? null,
                        'db_host' => $serverData['db_host'] ?? null,
                        'db_id' => $serverData['db_id'] ?? null,
                        'db_password' => $serverData['db_password'] ?? null,
                        'notes' => $serverData['notes'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.clients.index')
                ->with('success', '클라이언트가 성공적으로 수정되었습니다.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => '클라이언트 수정 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        try {
            DB::beginTransaction();

            // 관련 데이터 삭제
            $client->managers()->delete();
            $client->contracts()->delete();
            $client->serverInfo()->delete();
            $client->users()->delete();
            $client->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => '삭제 중 오류가 발생했습니다.'], 500);
        }
    }

    public function downloadContract($id)
    {
        $contract = Contract::findOrFail($id);

        if (!$contract->contract_file_path) {
            return back()->withErrors(['error' => '파일이 존재하지 않습니다.']);
        }

        $filePath = storage_path('app/public/' . $contract->contract_file_path);

        if (!file_exists($filePath)) {
            return back()->withErrors(['error' => '파일을 찾을 수 없습니다.']);
        }

        return response()->download($filePath, $contract->contract_file_name);
    }
}
