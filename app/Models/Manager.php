<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'client_id',
        'name',
        'position',
        'phone',
        'email',
        'role',
        'manager_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'idx');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('role', 'primary');
    }

    public function scopeSecondary($query)
    {
        return $query->where('role', 'secondary');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('manager_order');
    }
}
