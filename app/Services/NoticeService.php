<?php

namespace App\Services;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NoticeService
{
    /**
     * 공지사항 생성
     */
    public function createNotice(array $data): Notice
    {
        return DB::transaction(function () use ($data) {
            $notice = Notice::create([
                'user_id' => Auth::id(),
                'title' => $data['title'],
                'content' => $data['content'],
                'is_important' => $data['is_important'] ?? false,
                'is_published' => $data['is_published'] ?? true,
            ]);

            $this->handleAttachments($notice, request()->file('attachments'));
            
            return $notice;
        });
    }

    /**
     * 공지사항 수정
     */
    public function updateNotice(Notice $notice, array $data): Notice
    {
        return DB::transaction(function () use ($notice, $data) {
            $notice->update($data);
            
            $this->handleAttachments($notice, request()->file('attachments'));
            
            return $notice;
        });
    }

    /**
     * 공지사항 삭제
     */
    public function deleteNotice(Notice $notice): bool
    {
        return DB::transaction(function () use ($notice) {
            // 첨부파일 삭제
            foreach ($notice->files as $file) {
                Storage::disk('public')->delete($file->file_path);
            }
            
            return $notice->delete();
        });
    }

    /**
     * 대량 공지사항 삭제
     */
    public function bulkDeleteNotices(array $ids): bool
    {
        return DB::transaction(function () use ($ids) {
            $notices = Notice::whereIn('idx', $ids)->with('files')->get();
            
            foreach ($notices as $notice) {
                foreach ($notice->files as $file) {
                    Storage::disk('public')->delete($file->file_path);
                }
            }
            
            return Notice::whereIn('idx', $ids)->delete() > 0;
        });
    }

    /**
     * 첨부파일 처리
     */
    private function handleAttachments(Notice $notice, $attachments): void
    {
        if (!$attachments) {
            return;
        }

        foreach ($attachments as $file) {
            $path = $file->store('notice-files', 'public');
            $notice->files()->create([
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
            ]);
        }
    }

    /**
     * 공지사항 게시
     */
    public function publishNotice(Notice $notice): Notice
    {
        $notice->publish();
        return $notice;
    }

    /**
     * 공지사항 게시 취소
     */
    public function unpublishNotice(Notice $notice): Notice
    {
        $notice->unpublish();
        return $notice;
    }

    /**
     * 공지사항 중요 표시
     */
    public function markAsImportant(Notice $notice): Notice
    {
        $notice->markAsImportant();
        return $notice;
    }

    /**
     * 공지사항 중요 표시 해제
     */
    public function markAsNormal(Notice $notice): Notice
    {
        $notice->markAsNormal();
        return $notice;
    }

    /**
     * 대량 공지사항 게시
     */
    public function bulkPublishNotices(array $ids): bool
    {
        return Notice::whereIn('idx', $ids)->update([
            'is_published' => true,
            'published_at' => now()
        ]) > 0;
    }

    /**
     * 대량 공지사항 게시 취소
     */
    public function bulkUnpublishNotices(array $ids): bool
    {
        return Notice::whereIn('idx', $ids)->update([
            'is_published' => false,
            'published_at' => null
        ]) > 0;
    }

    /**
     * 대량 공지사항 중요 표시
     */
    public function bulkMarkAsImportant(array $ids): bool
    {
        return Notice::whereIn('idx', $ids)->update(['is_important' => true]) > 0;
    }

    /**
     * 대량 공지사항 중요 표시 해제
     */
    public function bulkMarkAsNormal(array $ids): bool
    {
        return Notice::whereIn('idx', $ids)->update(['is_important' => false]) > 0;
    }

    /**
     * 통계 데이터 생성
     */
    public function getStatistics(): array
    {
        // 전체 통계
        $totalNotices = Notice::count();
        $publishedNotices = Notice::published()->count();
        $importantNotices = Notice::important()->count();
        $draftNotices = Notice::where('is_published', false)->count();

        // 작성자별 통계
        $userStats = User::withCount(['notices' => function($query) {
            $query->published();
        }])->get();

        // 월별 통계
        $monthlyStats = Notice::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total,
            COUNT(CASE WHEN is_published = 1 THEN 1 END) as published,
            COUNT(CASE WHEN is_important = 1 THEN 1 END) as important
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return [
            'totalNotices' => $totalNotices,
            'publishedNotices' => $publishedNotices,
            'importantNotices' => $importantNotices,
            'draftNotices' => $draftNotices,
            'userStats' => $userStats,
            'monthlyStats' => $monthlyStats
        ];
    }
}
