<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;

use App\Http\Controllers\Admin\MaintenanceRequestController as AdminMaintenanceRequestController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\MonthlyReportController as AdminMonthlyReportController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;

// 인증 라우트
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware([
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class
]);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 인증이 필요한 라우트들
Route::middleware(['auth'])->group(function () {
    // 일반 사용자 홈페이지
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // 관리자 대시보드
    Route::get('/admin', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

    // 관리자 라우트
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        // 계정 관리 라우트
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [AdminAccountController::class, 'index'])->name('index');
            Route::get('/admins', [AdminAccountController::class, 'admins'])->name('admins');
            Route::get('/create', [AdminAccountController::class, 'create'])->name('create');
            Route::post('/', [AdminAccountController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminAccountController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminAccountController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminAccountController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [AdminAccountController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/check-duplicate', [AdminAccountController::class, 'checkDuplicate'])->name('check-duplicate');
        });



        // 관리자 유지보수 요청 라우트
        Route::prefix('maintenance-requests')->name('maintenance-requests.')->group(function () {
            Route::get('/', [AdminMaintenanceRequestController::class, 'index'])->name('index');
            Route::get('/create', [AdminMaintenanceRequestController::class, 'create'])->name('create');
            Route::post('/', [AdminMaintenanceRequestController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminMaintenanceRequestController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminMaintenanceRequestController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminMaintenanceRequestController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminMaintenanceRequestController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/assign', [AdminMaintenanceRequestController::class, 'assign'])->name('assign');
            Route::post('/{id}/status', [AdminMaintenanceRequestController::class, 'updateStatus'])->name('status');
            Route::post('/{id}/complete', [AdminMaintenanceRequestController::class, 'complete'])->name('complete');
            Route::get('/{id}/notes', [AdminMaintenanceRequestController::class, 'notes'])->name('notes');
            Route::get('/statistics', [AdminMaintenanceRequestController::class, 'statistics'])->name('statistics');
            
            // 댓글 관리 라우트
            Route::post('/{id}/comments', [AdminCommentController::class, 'store'])->name('comments.store');
            Route::put('/{id}/comments/{comment}', [AdminCommentController::class, 'update'])->name('comments.update');
            Route::delete('/{id}/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
            
            // 작업공수 관리 라우트
            Route::post('/{id}/work-hours', [AdminMaintenanceRequestController::class, 'updateWorkHours'])->name('work-hours.update');
            
            // 관리자 설정 관리 라우트
            Route::post('/{id}/admin-settings', [AdminMaintenanceRequestController::class, 'updateAdminSettings'])->name('admin-settings.update');
        });

        // 관리자 월간보고서 라우트
        Route::prefix('monthly-reports')->name('monthly-reports.')->group(function () {
            Route::get('/', [AdminMonthlyReportController::class, 'index'])->name('index');
            Route::get('/create', [AdminMonthlyReportController::class, 'create'])->name('create');
            Route::post('/', [AdminMonthlyReportController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminMonthlyReportController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminMonthlyReportController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminMonthlyReportController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminMonthlyReportController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/publish', [AdminMonthlyReportController::class, 'publish'])->name('publish');
            Route::post('/{id}/unpublish', [AdminMonthlyReportController::class, 'unpublish'])->name('unpublish');
            Route::get('/{id}/print', [AdminMonthlyReportController::class, 'print'])->name('print');
            Route::get('/statistics', [AdminMonthlyReportController::class, 'statistics'])->name('statistics');
            Route::post('/bulk-publish', [AdminMonthlyReportController::class, 'bulkPublish'])->name('bulk-publish');
            Route::post('/bulk-unpublish', [AdminMonthlyReportController::class, 'bulkUnpublish'])->name('bulk-unpublish');
            Route::post('/bulk-delete', [AdminMonthlyReportController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // 관리자 공지사항 라우트
        Route::prefix('notices')->name('notices.')->group(function () {
            Route::get('/', [AdminNoticeController::class, 'index'])->name('index');
            Route::get('/create', [AdminNoticeController::class, 'create'])->name('create');
            Route::post('/', [AdminNoticeController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminNoticeController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminNoticeController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminNoticeController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminNoticeController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [AdminNoticeController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/{id}/publish', [AdminNoticeController::class, 'publish'])->name('publish');
            Route::post('/{id}/unpublish', [AdminNoticeController::class, 'unpublish'])->name('unpublish');
            Route::post('/{id}/important', [AdminNoticeController::class, 'markAsImportant'])->name('important');
            Route::post('/{id}/normal', [AdminNoticeController::class, 'markAsNormal'])->name('normal');
            Route::get('/statistics', [AdminNoticeController::class, 'statistics'])->name('statistics');
            Route::post('/bulk-publish', [AdminNoticeController::class, 'bulkPublish'])->name('bulk-publish');
            Route::post('/bulk-unpublish', [AdminNoticeController::class, 'bulkUnpublish'])->name('bulk-unpublish');
            Route::post('/bulk-important', [AdminNoticeController::class, 'bulkMarkAsImportant'])->name('bulk-important');
            Route::post('/bulk-normal', [AdminNoticeController::class, 'bulkMarkAsNormal'])->name('bulk-normal');
            Route::get('/files/{file}/download', [AdminNoticeController::class, 'downloadFile'])->name('files.download');
        });

        // 관리자 환경설정 라우트
        Route::get('/preferences', [HomeController::class, 'adminPreferences'])->name('preferences');
    });

    // 유지보수 요청 라우트
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::resource('requests', MaintenanceRequestController::class);

        // 댓글 라우트
        Route::post('requests/{request}/comments', [CommentController::class, 'store'])->name('requests.comments.store');
        Route::put('requests/{request}/comments/{comment}', [CommentController::class, 'update'])->name('requests.comments.update');
        Route::delete('requests/{request}/comments/{comment}', [CommentController::class, 'destroy'])->name('requests.comments.destroy');
    });

    // 월간보고서 라우트
    Route::prefix('monthly-reports')->name('monthly-reports.')->group(function () {
        Route::get('/', [MonthlyReportController::class, 'index'])->name('index');
        Route::get('/create', [MonthlyReportController::class, 'create'])->name('create');
        Route::post('/', [MonthlyReportController::class, 'store'])->name('store');
        Route::get('/{id}', [MonthlyReportController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MonthlyReportController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MonthlyReportController::class, 'update'])->name('update');
        Route::delete('/{id}', [MonthlyReportController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/publish', [MonthlyReportController::class, 'publish'])->name('publish');
        Route::post('/{id}/unpublish', [MonthlyReportController::class, 'unpublish'])->name('unpublish');
        Route::get('/{id}/print', [MonthlyReportController::class, 'print'])->name('print');
    });

    // 공지사항 라우트
    Route::prefix('notices')->name('notices.')->group(function () {
        Route::get('/', [NoticeController::class, 'index'])->name('index');
        Route::get('/{id}', [NoticeController::class, 'show'])->name('show');
        Route::get('/create', [NoticeController::class, 'create'])->name('create');
        Route::post('/', [NoticeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [NoticeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [NoticeController::class, 'update'])->name('update');
        Route::delete('/{id}', [NoticeController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/publish', [NoticeController::class, 'publish'])->name('publish');
        Route::post('/{id}/unpublish', [NoticeController::class, 'unpublish'])->name('unpublish');
        Route::post('/{id}/important', [NoticeController::class, 'markAsImportant'])->name('important');
        Route::post('/{id}/normal', [NoticeController::class, 'markAsNormal'])->name('normal');
    });

    // 알림 라우트
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroy-all');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::get('/recent', [NotificationController::class, 'getRecentNotifications'])->name('recent');
    });

    // 계정 정보 라우트
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/edit', [AccountController::class, 'edit'])->name('edit');
        Route::put('/update', [AccountController::class, 'update'])->name('update');
    });
});

// 기존 PHP 파일 임시 연결 (마이그레이션 완료 후 제거)
Route::get('/legacy/{file}', function ($file) {
    $legacyPath = public_path("legacy/{$file}.php");
    if (file_exists($legacyPath)) {
        return response()->file($legacyPath);
    }
    abort(404);
})->where('file', '.*');

Route::get('/page_adm/{file}', function ($file) {
    $legacyPath = public_path("legacy/{$file}.php");
    if (file_exists($legacyPath)) {
        return response()->file($legacyPath);
    }
    abort(404);
})->where('file', '.*');
