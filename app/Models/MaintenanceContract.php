<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contract_start',
        'contract_end',
        'pm_hours',
        'design_hours',
        'publish_hours',
        'dev_hours',
        'contract_unit',
        'contract_file'
    ];

    protected $foreignKey = 'user_id';

    protected $casts = [
        'contract_start' => 'date',
        'contract_end' => 'date',
        'pm_hours' => 'integer',
        'design_hours' => 'integer',
        'publish_hours' => 'integer',
        'dev_hours' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'idx');
    }
}
