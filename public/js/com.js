$(document).ready(function(){
//ie_check
	var ua = window.navigator.userAgent;
	if(ua.indexOf('MSIE') > 0 || ua.indexOf('Trident/') > 0){ //윈도우 10까지는 MSIE 윈도우 11부터는 Trident/를 사용한다.
		document.body.className="ie";
	}
//헤더
	$(window).scroll(function() {
		if ($(window).scrollTop() > 100) {
			$(".header").addClass("fixed");
		} else {
			$(".header").removeClass("fixed");
		}
	});
	$(".btn_menu").click(function(){
		$("html,body").stop(false,true).toggleClass("over_h");
		$(".header").stop(false,true).toggleClass("on");
	});
	$(".header .bg").click(function(){
		$("html,body").removeClass("over_h");
		$(".header").removeClass("on");
	});
	$(".header .gnb .menu .mo_vw").click(function(){
		$(this).next(".snb").stop(false,true).slideToggle("fast").parent().stop(false,true).toggleClass("open").siblings().removeClass("open").removeClass("on").children(".snb").slideUp("fast");
	});
//팝업닫기
	$(".popup .btn_close,.popup .dm").click(function(){
		$(".popup").fadeOut("fast");
	});
//fancybox
	if (typeof $.fn.fancybox !== 'undefined') {
		$(".fancybox").fancybox();
	}
//브라우저 사이즈
	let vh = window.innerHeight * 0.01; 
	document.documentElement.style.setProperty('--vh', `${vh}px`);
//화면 리사이즈시 변경 
	window.addEventListener('resize', () => {
		let vh = window.innerHeight * 0.01; 
		document.documentElement.style.setProperty('--vh', `${vh}px`);
	});
	window.addEventListener('touchend', () => {
		let vh = window.innerHeight * 0.01;
		document.documentElement.style.setProperty('--vh', `${vh}px`);
	});
//AOS
	if (typeof AOS !== 'undefined') {
		AOS.init();
	}
//nice_select
	if (typeof $.fn.niceSelect !== 'undefined') {
		$("select").niceSelect();
	}
//설정
	$(".btn_setting").click(function(){
		$(".pop_setting").fadeIn("fast");
	});
	$(".pop_setting .btn_close, .pop_setting .dm, .pop_setting .btn_submit").click(function(){
		$(".pop_setting").fadeOut("fast");
	});

//tablet PC
	$(".main_wrap .btn_opcl .btn_open").click(function(){
		$(".info_area").addClass("on");
	});
	$(".main_wrap .btn_opcl .btn_close").click(function(){
		$(".info_area").removeClass("on");
	});
});