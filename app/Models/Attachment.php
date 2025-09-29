<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'request_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'original_name',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    // Relationships
    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'request_id');
    }

    // Scopes
    public function scopeByRequest($query, $requestId)
    {
        return $query->where('request_id', $requestId);
    }

    public function scopeByType($query, $fileType)
    {
        return $query->where('file_type', $fileType);
    }

    // Methods
    public function getFileSizeInMB()
    {
        return round($this->file_size / 1024 / 1024, 2);
    }

    public function getFileSizeInKB()
    {
        return round($this->file_size / 1024, 2);
    }

    public function getFileSizeFormatted()
    {
        if ($this->file_size >= 1024 * 1024) {
            return $this->getFileSizeInMB() . ' MB';
        } elseif ($this->file_size >= 1024) {
            return $this->getFileSizeInKB() . ' KB';
        } else {
            return $this->file_size . ' bytes';
        }
    }

    public function isImage()
    {
        return in_array($this->file_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function isDocument()
    {
        return in_array($this->file_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }

    public function getFileUrl()
    {
        return asset('storage/' . $this->file_path);
    }
}
