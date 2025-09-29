<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    /**
     * 계정 생성
     */
    public function createAccount(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->createUser($data);
            $this->createMaintenanceContracts($user, $data);
            return $user;
        });
    }

    /**
     * 기본 사용자 정보 생성
     */
    private function createUser(array $data): User
    {
        return User::create([
            'login_id' => $data['login_id'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'is_admin' => $data['member_type'] === 'admin',
            'is_active' => true,
            'member_type' => $data['member_type'],
            'new_type' => $data['new_type'] ?? null,
            'client_type' => $data['client_type'] ?? null,
            'is_confirmed_client' => $data['is_confirmed_client'] ?? false,
            'monthly_report' => $data['monthly_report'] ?? null,
            'manager_name' => $data['manager_name'],
            'manager_position' => $data['manager_position'] ?? null,
            'manager_phone' => $data['manager_phone'] ?? null,
            'manager_email' => $data['manager_email'] ?? null,
            'contact1_name' => $data['contact1_name'] ?? null,
            'contact1_position' => $data['contact1_position'] ?? null,
            'contact1_phone' => $data['contact1_phone'] ?? null,
            'contact1_email' => $data['contact1_email'] ?? null,
            'contact2_name' => $data['contact2_name'] ?? null,
            'contact2_position' => $data['contact2_position'] ?? null,
            'contact2_phone' => $data['contact2_phone'] ?? null,
            'contact2_email' => $data['contact2_email'] ?? null,
            'contact3_name' => $data['contact3_name'] ?? null,
            'contact3_position' => $data['contact3_position'] ?? null,
            'contact3_phone' => $data['contact3_phone'] ?? null,
            'contact3_email' => $data['contact3_email'] ?? null,
            'domain' => $data['domain'] ?? null,
            'sub_domain' => $data['sub_domain'] ?? null,
            'admin_url' => $data['admin_url'] ?? null,
            'admin_account' => $data['admin_account'] ?? null,
            'dev_language' => $data['dev_language'] ?? null,
            'db_type' => $data['db_type'] ?? null,
            'domain_agency' => $data['domain_agency'] ?? null,
            'server_agency' => $data['server_agency'] ?? null,
            'ssl_agency' => $data['ssl_agency'] ?? null,
            'ssl_expiry' => $data['ssl_expiry'] ?? null,
            'ftp_host' => $data['ftp_host'] ?? null,
            'ftp_id' => $data['ftp_id'] ?? null,
            'ftp_password' => $data['ftp_password'] ?? null,
            'ftp_id2' => $data['ftp_id2'] ?? null,
            'db_host' => $data['db_host'] ?? null,
            'db_id' => $data['db_id'] ?? null,
            'db_host2' => $data['db_host2'] ?? null,
            'db_id2' => $data['db_id2'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }

    /**
     * 유지보수 계약 정보 생성
     */
    private function createMaintenanceContracts(User $user, array $data): void
    {
        if (!isset($data['contract_start']) || !is_array($data['contract_start'])) {
            return;
        }

        for ($i = 0; $i < count($data['contract_start']); $i++) {
            if (empty($data['contract_start'][$i]) || empty($data['contract_end'][$i])) {
                continue;
            }

            $contractData = [
                'contract_start' => $data['contract_start'][$i],
                'contract_end' => $data['contract_end'][$i],
                'pm_hours' => $data['pm_hours'][$i] ?? 0,
                'design_hours' => $data['design_hours'][$i] ?? 0,
                'publish_hours' => $data['publish_hours'][$i] ?? 0,
                'dev_hours' => $data['dev_hours'][$i] ?? 0,
                'contract_unit' => $data['contract_unit'] ?? null,
            ];

            // 파일 업로드 처리
            if (isset($data['contract_files'][$i]) && $data['contract_files'][$i]->isValid()) {
                $file = $data['contract_files'][$i];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('contracts', $fileName, 'public');
                $contractData['contract_file'] = $filePath;
            }

            $user->maintenanceContracts()->create($contractData);
        }
    }

    /**
     * 계정 수정
     */
    public function updateAccount(User $user, array $data): User
    {
        $updateData = [
            'login_id' => $data['login_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'position' => $data['position'] ?? null,
            'contract_start' => $data['contract_start'] ?? null,
            'contract_end' => $data['contract_end'] ?? null,
            'is_admin' => $data['is_admin'] ?? false,
            'is_active' => $data['is_active'] ?? true
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        return $user;
    }

    /**
     * 계정 삭제
     */
    public function deleteAccount(User $user): bool
    {
        return $user->delete();
    }

    /**
     * 대량 계정 삭제
     */
    public function bulkDeleteAccounts(array $ids): bool
    {
        return DB::transaction(function () use ($ids) {
            return User::whereIn('idx', $ids)->delete() > 0;
        });
    }

    /**
     * 중복 로그인 ID 확인
     */
    public function isLoginIdDuplicate(string $loginId): bool
    {
        return User::where('login_id', $loginId)->exists();
    }
}
