<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'name',
        'client_type',
        'is_manpower_check',
        'monthly_report_enabled',
        'contract_start',
        'contract_end',
        'website_url',
        'is_active',
    ];

    protected $casts = [
        'contract_start' => 'date',
        'contract_end' => 'date',
        'is_manpower_check' => 'boolean',
        'monthly_report_enabled' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function serverInfo()
    {
        return $this->hasOne(ServerInfo::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeManpowerCheck($query)
    {
        return $query->where('is_manpower_check', true);
    }

    public function scopeMonthlyReportEnabled($query)
    {
        return $query->where('monthly_report_enabled', true);
    }

    // Methods
    public function isActive()
    {
        return $this->contract_start <= now() && $this->contract_end >= now();
    }

    public function getPrimaryManager()
    {
        return $this->managers()->primary()->first();
    }

    public function getActiveContracts()
    {
        return $this->contracts()->active()->ordered()->get();
    }
}
