/**
 * 관리자 공지사항 리스트 페이지 스크립트
 * - 체크박스 전체 선택, 선택 삭제 기능 초기화
 */
document.addEventListener('DOMContentLoaded', function () {

    // 전체 선택 체크박스
    var allCheck = document.getElementById('allCheck');
    if (allCheck) {
        allCheck.addEventListener('change', function () {
            var checks = document.querySelectorAll("input[name='check']");
            checks.forEach(function (c) { c.checked = allCheck.checked; });
        });
    }

    // 선택 삭제 버튼
    var deleteBtn = document.getElementById('deleteSelected');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            var ids = Array.from(document.querySelectorAll("input[name='check']:checked"))
                .map(function (el) { return el.value; });
            if (ids.length === 0) { return; }
            if (!confirm('선택한 항목을 삭제하시겠습니까?')) { return; }

            fetch('/admin/notices/bulk-delete', {
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


