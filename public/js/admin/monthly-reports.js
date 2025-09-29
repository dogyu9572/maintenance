document.addEventListener('DOMContentLoaded', function () {
    if (typeof CommonDatepicker !== 'undefined') {
        CommonDatepicker.init();
    }

    // 성공 메시지 확인 및 알럿 표시
    var successAlert = document.querySelector('.alert-success');
    if (successAlert && successAlert.textContent.includes('등록되었습니다')) {
        setTimeout(function() {
            alert('월간보고서가 성공적으로 저장되었습니다!');
        }, 100);
    }

    var allCheck = document.getElementById('allCheck');
    if (allCheck) {
        allCheck.addEventListener('change', function () {
            var checks = document.querySelectorAll("input[name='check']");
            checks.forEach(function (c) { c.checked = allCheck.checked; });
        });
    }

    var deleteBtn = document.getElementById('deleteSelected');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            var ids = Array.from(document.querySelectorAll("input[name='check']:checked"))
                .map(function (el) { return el.value; });
            if (ids.length === 0) { return; }
            if (!confirm('선택한 항목을 삭제하시겠습니까?')) { return; }

            fetch('/admin/monthly-reports/bulk-delete', {
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

    var publishBtn = document.getElementById('publishSelected');
    if (publishBtn) {
        publishBtn.addEventListener('click', function () {
            var ids = Array.from(document.querySelectorAll("input[name='check']:checked"))
                .map(function (el) { return el.value; });
            if (ids.length === 0) { return; }
            if (!confirm('선택한 항목을 노출 상태로 변경하시겠습니까?')) { return; }

            fetch('/admin/monthly-reports/bulk-publish', {
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
                    alert('선택한 항목이 노출 상태로 변경되었습니다.');
                    window.location.reload();
                } else {
                    alert('변경 중 오류가 발생했습니다.');
                }
            })
            .catch(function () {
                alert('변경 중 오류가 발생했습니다.');
            });
        });
    }
});


