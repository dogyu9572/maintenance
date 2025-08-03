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

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'idx');
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

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
