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
        'assigned_user_id',
        'maintenance_type_id',
        'status_id',
        'title',
        'content',
        'priority',
        'estimated_pm_hours',
        'estimated_design_hours',
        'estimated_publishing_hours',
        'estimated_development_hours',
        'actual_pm_hours',
        'actual_design_hours',
        'actual_publishing_hours',
        'actual_development_hours',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'estimated_pm_hours' => 'integer',
        'estimated_design_hours' => 'integer',
        'estimated_publishing_hours' => 'integer',
        'estimated_development_hours' => 'integer',
        'actual_pm_hours' => 'integer',
        'actual_design_hours' => 'integer',
        'actual_publishing_hours' => 'integer',
        'actual_development_hours' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function maintenanceType()
    {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id');
    }

    public function status()
    {
        return $this->belongsTo(RequestStatus::class, 'status_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'maintenance_request_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'maintenance_request_id');
    }
}
