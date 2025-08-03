<div class="header">
	<a href="{{ route('home') }}" class="logo">
		<img src="{{ asset('images/logo.png') }}" alt="logo"><span>유지보수</span><h1>홈페이지코리아 유지보수</h1>
	</a>
	<a href="{{ route('notifications.index') }}" class="alarm mo_vw">알림내역<span>4</span></a>
	<a href="javascript:void(0);" class="btn_menu">
		<p class="t"></p>
		<p class="m"></p>
		<p class="b"></p>
	</a>
	<div class="gnb_wrap">
		<div class="bg"></div>
		<div class="gnb_area">
			<div class="gnb">
			@if(Auth::check() && Auth::user()->isAdmin())
				@php
					$gnb0Class = isset($gNum) && $gNum == "00" ? "on" : "";
					$gnb1Class = isset($gNum) && $gNum == "01" ? "on" : "";
					$gnb2Class = isset($gNum) && $gNum == "02" ? "on" : "";
					$gnb3Class = isset($gNum) && $gNum == "03" ? "on" : "";
					$gnb4Class = isset($gNum) && $gNum == "04" ? "on" : "";
					$gnb5Class = isset($gNum) && $gNum == "05" ? "on" : "";
				@endphp
				<div class="menu gnb0 {{ $gnb0Class }}"><a href="{{ route('admin.dashboard') }}">홈</a></div>
				<div class="menu gnb1 {{ $gnb1Class }}"><a href="{{ route('admin.maintenance-requests.index') }}">유지보수 요청</a></div>
				<div class="menu gnb2 {{ $gnb2Class }}"><a href="{{ route('admin.monthly-reports.index') }}">월간보고서</a></div>
				<div class="menu gnb3 {{ $gnb3Class }}"><a href="{{ route('admin.notices.index') }}">공지사항</a></div>
				<div class="menu gnb4 {{ $gnb4Class }}"><a href="{{ route('admin.accounts.index') }}">계정 관리</a></div>
				<div class="menu gnb5 {{ $gnb5Class }}"><a href="{{ route('admin.preferences') }}">환경설정</a></div>
			@else
				@php
					$gnb0Class = isset($gNum) && $gNum == "00" ? "on" : "";
					$gnb1Class = isset($gNum) && $gNum == "01" ? "on" : "";
					$gnb2Class = isset($gNum) && $gNum == "02" ? "on" : "";
					$gnb3Class = isset($gNum) && $gNum == "03" ? "on" : "";
					$gnb4Class = isset($gNum) && $gNum == "04" ? "on" : "";
					$gnb5Class = isset($gNum) && $gNum == "05" ? "on" : "";
				@endphp
				<div class="menu gnb0 {{ $gnb0Class }}"><a href="{{ route('home') }}">홈</a></div>
				<div class="menu gnb1 {{ $gnb1Class }}"><a href="{{ route('maintenance.requests.index') }}">유지보수 요청</a></div>
				<div class="menu gnb2 {{ $gnb2Class }}"><a href="{{ route('monthly-reports.index') }}">월간보고서</a></div>
				<div class="menu gnb3 {{ $gnb3Class }}"><a href="{{ route('notices.index') }}">공지사항</a></div>
				<div class="menu gnb4 {{ $gnb4Class }}"><a href="{{ route('notifications.index') }}">알림내역</a></div>
				<div class="menu gnb5 {{ $gnb5Class }}"><a href="{{ route('account.index') }}">계정 정보</a></div>
			@endif
			</div>
			<div class="right">
				<div class="name"><i></i>{{ Auth::user()->name ?? '한국심초음파학회' }}</div>
				<form method="POST" action="{{ route('logout') }}" style="display: inline;">
					@csrf
					<button type="submit" class="btn_log" style="background: none; border: none; cursor: pointer;">LOGOUT</button>
				</form>
			</div>
		</div>
	</div>
</div>
