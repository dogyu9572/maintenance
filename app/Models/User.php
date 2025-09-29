<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'idx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login_id',
        'username',
        'email',
        'password',
        'phone',
        'position',
        'client_id',
        'contract_start',
        'contract_end',
        'is_admin',
        'is_active',
        'member_type',
        'new_type',
        'client_type',
        'is_confirmed_client',
        'monthly_report',
        'manager_name',
        'manager_position',
        'manager_phone',
        'manager_email',
        'contact1_name',
        'contact1_position',
        'contact1_phone',
        'contact1_email',
        'contact2_name',
        'contact2_position',
        'contact2_phone',
        'contact2_email',
        'contact3_name',
        'contact3_position',
        'contact3_phone',
        'contact3_email',
        'domain',
        'sub_domain',
        'admin_url',
        'admin_account',
        'dev_language',
        'db_type',
        'domain_agency',
        'server_agency',
        'ssl_agency',
        'ssl_expiry',
        'ftp_host',
        'ftp_id',
        'ftp_password',
        'ftp_id2',
        'db_host',
        'db_id',
        'db_host2',
        'db_id2',
        'notes'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'contract_start' => 'date',
            'contract_end' => 'date',
        ];
    }



    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'user_id');
    }

    public function managedRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'manager_id');
    }

    public function workedRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'worker_id');
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function maintenanceContracts()
    {
        return $this->hasMany(MaintenanceContract::class, 'user_id', 'idx');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * 계정 유형 텍스트 (신규/기존)
     */
    public function getAccountTypeTextAttribute(): string
    {
        return match($this->account_type) {
            'new' => '신규',
            'renewal' => '기존',
            default => '미정'
        };
    }

    /**
     * 고객사 유형 텍스트 (병원/협회/개인)
     */
    public function getClientTypeTextAttribute(): string
    {
        return match($this->client_type) {
            'company' => '병원',
            'association' => '협회',
            'individual' => '개인',
            default => '미정'
        };
    }

    /**
     * 계약 기간 텍스트 (시작일~종료일)
     */
    public function getContractPeriodTextAttribute(): string
    {
        if (!$this->contract_start && !$this->contract_end) {
            return '';
        }
        
        $start = $this->contract_start?->format('Y.m.d') ?? '';
        $end = $this->contract_end?->format('Y.m.d') ?? '';
        
        if ($start && $end) {
            return "{$start}~{$end}";
        }
        
        return $start ?: $end;
    }

    /**
     * 상태 텍스트 (Y/N)
     */
    public function getStatusTextAttribute(): string
    {
        return $this->is_active ? 'Y' : 'N';
    }

    /**
     * 생성일 포맷팅
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at?->format('Y.m.d') ?? '';
    }
}
