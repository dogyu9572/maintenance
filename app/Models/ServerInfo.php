<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';
    protected $table = 'server_info';

    protected $fillable = [
        'client_id',
        'domain',
        'sub_domain',
        'admin_url',
        'admin_account',
        'development_language',
        'database_type',
        'domain_provider',
        'server_provider',
        'ssl_provider',
        'ssl_expiry_date',
        'ftp_host',
        'ftp_id',
        'ftp_password',
        'db_host',
        'db_id',
        'db_password',
        'notes',
    ];

    protected $casts = [
        'ssl_expiry_date' => 'date',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scopes
    public function scopeWithExpiringSsl($query, $days = 30)
    {
        return $query->whereNotNull('ssl_expiry_date')
                    ->where('ssl_expiry_date', '<=', now()->addDays($days));
    }

    // Methods
    public function isSslExpiringSoon($days = 30)
    {
        return $this->ssl_expiry_date && $this->ssl_expiry_date->diffInDays(now()) <= $days;
    }

    public function getFullDomainAttribute()
    {
        if ($this->sub_domain) {
            return $this->sub_domain . '.' . $this->domain;
        }
        return $this->domain;
    }
}
