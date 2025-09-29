<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'name',
        'color',
        'order',
    ];

    // Relationships
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'status_id');
    }
}
