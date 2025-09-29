<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_important',
        'is_published',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'is_important' => 'boolean',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        // users 테이블의 기본키가 idx이므로 소유 키를 명시한다.
        return $this->belongsTo(User::class, 'user_id', 'idx');
    }

    public function files()
    {
        return $this->hasMany(NoticeFile::class, 'notice_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function isImportant()
    {
        return $this->is_important;
    }

    public function isPublished()
    {
        return $this->is_published;
    }

    public function publish()
    {
        $this->update([
            'is_published' => true,
            'published_at' => now()
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'is_published' => false,
            'published_at' => null
        ]);
    }

    public function markAsImportant()
    {
        $this->update(['is_important' => true]);
    }

    public function markAsNormal()
    {
        $this->update(['is_important' => false]);
    }
}
