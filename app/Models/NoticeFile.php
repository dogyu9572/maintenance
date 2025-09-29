<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeFile extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'notice_id',
        'original_name',
        'file_path',
        'file_size',
        'file_type',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function notice()
    {
        return $this->belongsTo(Notice::class, 'notice_id');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}


