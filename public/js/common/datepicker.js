/**
 * 공통 Datepicker 설정
 */
class CommonDatepicker {
    static init(selector = ".datepicker") {
        $(selector).datepicker({
            dateFormat: 'yy-mm-dd',
            showMonthAfterYear: true,
            showOn: "both",
            buttonImage: "/images/icon_month.svg",
            buttonImageOnly: true,
            changeYear: true,
            changeMonth: true,
            yearRange: 'c-100:c+10',
            yearSuffix: "년 ",
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNamesMin: ['일','월','화','수','목','금','토']
        });
    }

    static setDefaultRange(startSelector = ".datepicker_start", endSelector = ".datepicker_end") {
        var today = new Date();
        var sixMonthsAgo = new Date();
        sixMonthsAgo.setMonth(today.getMonth() - 6);

        if (!$(startSelector).val()) {
            $(startSelector).datepicker("setDate", sixMonthsAgo);
        }
        if (!$(endSelector).val()) {
            $(endSelector).datepicker("setDate", today);
        }
    }
}

// 자동 초기화
$(document).ready(function() {
    CommonDatepicker.init();
    
    // datepicker_today 클래스가 있는 경우 오늘 날짜로 설정
    $(".datepicker_today").each(function() {
        if (!$(this).val()) {
            var today = new Date();
            $(this).datepicker("setDate", today);
        }
    });
}); 