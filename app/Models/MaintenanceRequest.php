<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'user_id',
        'manager_id',
        'worker_id',
        'type_id',
        'status_id',
        'title',
        'content',
        'request_date',
        'expected_date',
        'completed_date',
        'expected_pm_hours',
        'expected_design_hours',
        'expected_pub_hours',
        'expected_dev_hours',
        'actual_pm_hours',
        'actual_design_hours',
        'actual_pub_hours',
        'actual_dev_hours',
        'is_urgent',
        'notes',
        'issues',
        'report_title',
        'progress_rate',
        'progress_status',
    ];

    protected $casts = [
        'request_date' => 'date',
        'expected_date' => 'date',
        'completed_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function maintenanceType()
    {
        return $this->belongsTo(MaintenanceType::class, 'type_id');
    }

    public function status()
    {
        return $this->belongsTo(RequestStatus::class, 'status_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'request_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'maintenance_request_id');
    }
}
