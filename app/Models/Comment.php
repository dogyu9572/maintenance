<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';
    public $incrementing = true;

    protected $fillable = [
        'maintenance_request_id',
        'user_id',
        'content',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id', 'idx');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'idx');
    }

    public function getTypeName()
    {
        $types = [
            'comment' => '댓글',
            'reply' => '답변',
            'rework' => '재요청',
            'complete' => '작업완료',
        ];

        return $types[$this->type] ?? '댓글';
    }
}
