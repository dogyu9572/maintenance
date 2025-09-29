/**
 * 계정 관리 페이지 JavaScript (jQuery 의존 최소화)
 * - 디자인 변경 없음
 * - jQuery UI Datepicker는 공통 모듈에서 관리되므로 호출은 유지
 */
document.addEventListener('DOMContentLoaded', function () {
    // 공통 기능 초기화
    CommonDatepicker.init();
    if (typeof TableActions !== 'undefined') {
        TableActions.initCheckboxes();
        TableActions.initBulkDelete('#deleteSelected', "input[name='check']");
        TableActions.initPageSizeChange();
    }

    // 전체 선택 체크박스 동작
    var allCheck = document.getElementById('allCheck');
    if (allCheck) {
        allCheck.addEventListener('change', function () {
            var checks = document.querySelectorAll("input[name='check']");
            checks.forEach(function (c) { c.checked = allCheck.checked; });
        });
    }

    // 선택 삭제 버튼 동작 (성공 시 알럿 후 리로드)
    var deleteBtn = document.getElementById('deleteSelected');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            var ids = Array.from(document.querySelectorAll("input[name='check']:checked")).map(function (el) { return el.value; });
            if (ids.length === 0) { return; }
            if (!confirm('선택한 항목을 삭제하시겠습니까?')) { return; }

            fetch('/admin/accounts/bulk-delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: ids })
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data && data.success) {
                    alert('선택한 항목이 삭제되었습니다.');
                    window.location.reload();
                } else {
                    alert('삭제 중 오류가 발생했습니다.');
                }
            })
            .catch(function () {
                alert('삭제 중 오류가 발생했습니다.');
            });
        });
    }
});