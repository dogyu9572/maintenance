<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'user_id',
        'client_id',
        'year',
        'month',
        'title',
        'content',
        'status',
        'is_published',
        'work_start_date',
        'work_end_date',
        'project_name',
        'manager_name',
        'company_name',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'is_published' => 'boolean',
    ];

    // 상수 정의
    const PER_PAGE = 15;
    const G_NUM = '02';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByYearMonth($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeOrderByYearMonth($query)
    {
        return $query->orderBy('year', 'desc')->orderBy('month', 'desc');
    }

    // Methods
    public function getYearMonthAttribute()
    {
        return sprintf('%04d-%02d', $this->year, $this->month);
    }

    public function getWorkPeriodAttribute()
    {
        if ($this->work_start_date && $this->work_end_date) {
            return $this->work_start_date->format('Y.m.d') . ' ~ ' . $this->work_end_date->format('Y.m.d');
        }
        return '';
    }

    public function isPublished()
    {
        return $this->is_published;
    }

    public function publish()
    {
        $this->update(['is_published' => true]);
    }

    public function unpublish()
    {
        $this->update(['is_published' => false]);
    }

    public function canEdit()
    {
        return !$this->is_published;
    }

    public function canDelete()
    {
        return !$this->is_published;
    }
}
