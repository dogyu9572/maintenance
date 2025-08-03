<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'name',
        'description',
    ];

    // Relationships
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'type_id');
    }
}
