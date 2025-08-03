<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 - 홈페이지코리아 유지보수</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reactive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
</head>
<body>
<div id="mainContent" class="intro_wrap">

	<div class="intro_area">
		<div class="inbox">
			<div class="logo"><img src="{{ asset('images/logo.png') }}" alt="logo"><span>유지보수</span></div>
			<p>아이디 또는 비밀번호를 입력해주세요.</p>
			<form method="POST" action="{{ route('login') }}">
				@csrf
				<input type="text" name="login_id" class="text w100p" placeholder="아이디를 입력해주세요." value="{{ old('login_id') }}" required autofocus>
				@error('login_id')
					<span class="error">{{ $message }}</span>
				@enderror
				<input type="password" name="password" class="text w100p mb0" placeholder="비밀번호를 입력해주세요." required>
				<button type="submit" class="btn">로그인</button>
			</form>

		</div>
		<div class="copy">Copyright © Homepagekorea. All Rights Reserved</div>
	</div>

</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/com.js') }}"></script>
</body>
</html>
