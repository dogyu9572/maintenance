<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'client_id',
        'contract_start',
        'contract_end',
        'pm_hours',
        'design_hours',
        'publishing_hours',
        'development_hours',
        'contract_file_path',
        'contract_file_name',
        'contract_order',
        'is_active',
    ];

    protected $casts = [
        'contract_start' => 'date',
        'contract_end' => 'date',
        'pm_hours' => 'decimal:2',
        'design_hours' => 'decimal:2',
        'publishing_hours' => 'decimal:2',
        'development_hours' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('contract_order', 'desc');
    }

    public function scopeCurrent($query)
    {
        return $query->where('contract_start', '<=', now())
                    ->where('contract_end', '>=', now());
    }

    // Methods
    public function getTotalHoursAttribute()
    {
        return $this->pm_hours + $this->design_hours + $this->publishing_hours + $this->development_hours;
    }

    public function isActive()
    {
        return $this->contract_start <= now() && $this->contract_end >= now();
    }
}
