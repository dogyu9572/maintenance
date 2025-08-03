<div class="header">
	<?if($type=="adm"){?>
	<a href="/main_adm.php" class="logo">
	<?}else{?>
	<a href="/main.php" class="logo">
	<?}?>
		<img src="/pub/images/logo.png" alt="logo"><span>유지보수</span><h1>홈페이지코리아 유지보수</h1>
	</a>
	<a href="/page/notifications.php" class="alarm mo_vw">알림내역<span>4</span></a>
	<a href="javascript:void(0);" class="btn_menu">
		<p class="t"></p>
		<p class="m"></p>
		<p class="b"></p>
	</a>
	<div class="gnb_wrap">
		<div class="bg"></div>
		<div class="gnb_area">
			<div class="gnb">
			<?if($type=="adm"){?>
				<div class="menu gnb0 <?if($gNum=="00"){?>on<?}?>"><a href="/main_adm.php">홈</a></div>
				<div class="menu gnb1 <?if($gNum=="01"){?>on<?}?>"><a href="/page_adm/maintenance_requests.php">유지보수 요청</a></div>
				<div class="menu gnb2 <?if($gNum=="02"){?>on<?}?>"><a href="/page_adm/monthly_reports.php">월간보고서</a></div>
				<div class="menu gnb3 <?if($gNum=="03"){?>on<?}?>"><a href="/page_adm/notices.php">공지사항</a></div>
				<div class="menu gnb4 <?if($gNum=="04"){?>on<?}?>"><a href="/page_adm/account.php">계정 관리</a></div>
				<div class="menu gnb5 <?if($gNum=="05"){?>on<?}?>"><a href="/page_adm/preferences.php">환경설정</a></div>
			<?}else{?>
				<div class="menu gnb0 <?if($gNum=="00"){?>on<?}?>"><a href="/main.php">홈</a></div>
				<div class="menu gnb1 <?if($gNum=="01"){?>on<?}?>"><a href="/page/maintenance_requests.php">유지보수 요청</a></div>
				<div class="menu gnb2 <?if($gNum=="02"){?>on<?}?>"><a href="/page/monthly_reports.php">월간보고서</a></div>
				<div class="menu gnb3 <?if($gNum=="03"){?>on<?}?>"><a href="/page/notices.php">공지사항</a></div>
				<div class="menu gnb4 <?if($gNum=="04"){?>on<?}?>"><a href="/page/notifications.php">알림내역</a></div>
				<div class="menu gnb5 <?if($gNum=="05"){?>on<?}?>"><a href="/page/account_information.php">계정 정보</a></div>
			<?}?>
			</div>
			<div class="right">
				<div class="name"><i></i>한국심초음파학회</div>
				<a href="javascript:void(0);" class="btn_log">LOGOUT</a>
			</div>
		</div>
	</div>
</div>