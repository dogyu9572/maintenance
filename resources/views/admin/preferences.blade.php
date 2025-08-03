@extends('layouts.app')

@section('title', '환경설정')

@section('content')
<div class="main_wrap">
    <div class="content_area">
        <div class="content">
            <div class="title_area">
                <h2>환경설정</h2>
            </div>
            
            <div class="setting_area">
                <div class="setting_group">
                    <h3>시스템 설정</h3>
                    <div class="setting_item">
                        <label>디버그 모드</label>
                        <div class="setting_value">
                            <span class="status {{ config('app.debug') ? 'on' : 'off' }}">
                                {{ config('app.debug') ? '활성화' : '비활성화' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="setting_item">
                        <label>로그 레벨</label>
                        <div class="setting_value">
                            <span>{{ config('logging.default') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="setting_group">
                    <h3>데이터베이스 설정</h3>
                    <div class="setting_item">
                        <label>연결 상태</label>
                        <div class="setting_value">
                            <span class="status on">정상</span>
                        </div>
                    </div>
                    
                    <div class="setting_item">
                        <label>쿼리 로깅</label>
                        <div class="setting_value">
                            <span class="status {{ config('database.connections.mysql.logging') ? 'on' : 'off' }}">
                                {{ config('database.connections.mysql.logging') ? '활성화' : '비활성화' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="setting_group">
                    <h3>사용자 통계</h3>
                    <div class="setting_item">
                        <label>전체 사용자</label>
                        <div class="setting_value">
                            <span>{{ \App\Models\User::count() }}명</span>
                        </div>
                    </div>
                    
                    <div class="setting_item">
                        <label>관리자</label>
                        <div class="setting_value">
                            <span>{{ \App\Models\User::where('is_admin', true)->count() }}명</span>
                        </div>
                    </div>
                    
                    <div class="setting_item">
                        <label>일반 사용자</label>
                        <div class="setting_value">
                            <span>{{ \App\Models\User::where('is_admin', false)->count() }}명</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 