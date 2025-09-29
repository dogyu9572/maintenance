/**
 * 계정생성 페이지 JavaScript (jQuery 의존 최소화)
 * - 디자인 변경 없음
 * - Datepicker는 jQuery UI 기반이므로 해당 부분만 jQuery 의존 유지
 */
document.addEventListener('DOMContentLoaded', function () {
    // 중복확인 상태 변수
    let isDuplicateChecked = false;
    let isDuplicateAvailable = false;

    // 파일 선택 UI 처리 (동적 요소 포함)
    document.addEventListener('change', function (event) {
        const target = event.target;
        if (!(target instanceof HTMLInputElement)) return;
        if (!target.matches('.searchfile')) return;

        const filePath = target.value || '';
        const parts = filePath.split('\\');
        const fileName = parts[parts.length - 1] || '';

        const container = target.closest('.file_input');
        if (!container) return;
        const filebox = container.querySelector('.filebox');
        if (filebox) filebox.textContent = fileName;
        container.classList.add('on');
    });

    // 중복확인 버튼
    document.addEventListener('click', async function (event) {
        const button = event.target.closest('#checkDuplicate');
        if (!button) return;

        const loginInput = document.querySelector('input[name="login_id"]');
        const loginId = loginInput ? loginInput.value.trim() : '';
        if (!loginId) {
            alert('ID를 입력해주세요.');
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        try {
            const response = await fetch('/admin/accounts/check-duplicate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                },
                body: new URLSearchParams({ login_id: loginId }),
            });
            const data = await response.json();
            isDuplicateChecked = true;
            if (data && data.available) {
                isDuplicateAvailable = true;
                alert('사용 가능한 ID입니다.');
            } else {
                isDuplicateAvailable = false;
                alert('이미 사용 중인 ID입니다.');
            }
        } catch (error) {
            console.error(error);
            alert('중복확인 중 오류가 발생했습니다.');
        }
    });

    // 필드추가 버튼
    document.addEventListener('click', function (event) {
        const button = event.target.closest('#addMaintenanceField');
        if (!button) return;

        const tbody = document.querySelector('#maintenanceTableBody');
        if (!tbody) return;
        const rowCount = tbody.querySelectorAll('tr').length + 1;

        const newRowHtml = `
            <tr>
                <td class="num">${rowCount}</td>
                <td class="order1">
                    <div class="flex datepicker_wrap">
                        <div class="datepicker_area">
                            <input type="text" name="contract_start[]" class="text datepicker w100p">
                        </div>
                        <span></span>
                        <div class="datepicker_area">
                            <input type="text" name="contract_end[]" class="text datepicker w100p">
                        </div>
                    </div>
                </td>
                <td class="order2">
                    <div class="flex">
                        <dl>
                            <dt>PM,기획</dt>
                            <dd><input type="text" name="pm_hours[]" class="text bgw"></dd>
                        </dl>
                        <dl>
                            <dt>디자인</dt>
                            <dd><input type="text" name="design_hours[]" class="text bgw"></dd>
                        </dl>
                        <dl>
                            <dt>퍼블리싱</dt>
                            <dd><input type="text" name="publish_hours[]" class="text bgw"></dd>
                        </dl>
                        <dl>
                            <dt>개발</dt>
                            <dd><input type="text" name="dev_hours[]" class="text bgw"></dd>
                        </dl>
                    </div>
                </td>
                <td class="order3 file_wrap">
                    <div class="file_input">
                        <label class="filebutton">
                            <span>파일찾기</span>
                            <input type="file" name="contract_files[]" class="searchfile" title="파일 찾기">
                        </label>
                        <div class="filebox"></div>
                    </div>
                </td>
                <td class="order4 del_wrap">
                    <button type="button" class="btn_del">삭제</button>
                </td>
            </tr>`;

        tbody.insertAdjacentHTML('beforeend', newRowHtml);

        // 새로 추가된 행의 datepicker 초기화 (jQuery UI 유지)
        const lastRow = tbody.lastElementChild;
        if (lastRow) {
            const dateInputs = lastRow.querySelectorAll('.datepicker');
            if (dateInputs && dateInputs.length) {
                dateInputs.forEach(function (inputEl) {
                    CommonDatepicker.init(inputEl);
                });
            }
        }
    });

    // 삭제 버튼 (동적 요소 포함)
    document.addEventListener('click', function (event) {
        const deleteBtn = event.target.closest('.btn_del');
        if (!deleteBtn) return;

        if (!confirm('정말 삭제하시겠습니까?')) return;

        const row = deleteBtn.closest('tr');
        if (row) row.remove();

        // 번호 재정렬
        const numbers = document.querySelectorAll('#maintenanceTableBody tr .num');
        numbers.forEach((el, index) => {
            el.textContent = String(index + 1);
        });
    });

    // 폼 제출 시 중복확인 체크 및 AJAX 처리
    const form = document.querySelector('#accountForm');
    
    if (form) {
        form.addEventListener('submit', async function (event) {
            const loginInput = document.querySelector('input[name="login_id"]');
            const loginId = loginInput ? loginInput.value.trim() : '';

            if (loginId && !isDuplicateChecked) {
                event.preventDefault();
                alert('ID 중복확인을 먼저 해주세요.');
                return;
            }

            if (loginId && isDuplicateChecked && !isDuplicateAvailable) {
                event.preventDefault();
                alert('사용할 수 없는 ID입니다. 다른 ID를 입력하고 중복확인을 해주세요.');
                return;
            }

            event.preventDefault();

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData(form);

            // 파일 업로드 처리를 위한 FormData 구성
            const fileInputs = form.querySelectorAll('input[type="file"]');
            fileInputs.forEach((fileInput, index) => {
                if (fileInput.files && fileInput.files[0]) {
                    formData.set(fileInput.name, fileInput.files[0]);
                }
            });

            try {
                const response = await fetch(form.getAttribute('action'), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();
                
                if (data && data.success) {
                    alert(data.message);
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else if (data && data.errors) {
                    let errorMessage = '다음 오류가 발생했습니다:\n';
                    Object.keys(data.errors).forEach(key => {
                        const arr = data.errors[key];
                        if (Array.isArray(arr) && arr.length) errorMessage += arr[0] + '\n';
                    });
                    alert(errorMessage);
                } else {
                    alert('저장 중 오류가 발생했습니다.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('저장 중 오류가 발생했습니다.');
            }
        });
    }

    // ID 입력 필드 변경 시 중복확인 상태 초기화
    const loginInput = document.querySelector('input[name="login_id"]');
    if (loginInput) {
        loginInput.addEventListener('input', function () {
            isDuplicateChecked = false;
            isDuplicateAvailable = false;
        });
    }
});