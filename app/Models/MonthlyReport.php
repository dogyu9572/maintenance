<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'client_id',
        'user_id',
        'year',
        'month',
        'title',
        'content',
        'status',
        'is_published',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    // Methods
    public function getYearMonthAttribute()
    {
        return sprintf('%04d-%02d', $this->year, $this->month);
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
}
