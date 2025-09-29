document.addEventListener('DOMContentLoaded', function () {
    if (typeof CommonDatepicker !== 'undefined') {
        CommonDatepicker.init();
    }

    // 폼 제출 이벤트 리스너 추가
    var form = document.getElementById('monthlyReportForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            console.log('폼 제출 시도됨');
            
            // 필수 필드 검증
            var title = form.querySelector('input[name="title"]').value;
            var clientId = form.querySelector('select[name="client_id"]').value;
            
            if (!clientId) {
                e.preventDefault();
                alert('고객사명을 선택해주세요.');
                return false;
            }
            
            if (!title.trim()) {
                e.preventDefault();
                alert('제목을 입력해주세요.');
                return false;
            }
            
            console.log('폼 제출 진행됨');
        });
    }

    // 성공 메시지 표시 (세션 플래시 메시지 확인)
    // Laravel의 세션 플래시 메시지를 확인
    var successMessage = document.querySelector('.alert-success, .alert, [data-success]');
    if (successMessage) {
        var message = successMessage.textContent || successMessage.innerText;
        if (message.includes('등록되었습니다') || message.includes('저장되었습니다')) {
            alert('월간보고서가 성공적으로 저장되었습니다!');
        }
    }

    var addBtn = document.querySelector('.btn_addfield');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            var tbody = document.querySelector('.tbl_addfield table tbody');
            var rowCount = tbody.querySelectorAll('tr').length + 1;
            var template = document.createElement('template');
            template.innerHTML = `
            <tr>
              <td class="num">${rowCount}</td>
              <td class="report1"><input type="text" name="work_items[${rowCount}][title]" class="text w100p" value=""></td>
              <td class="report2"><input type="text" name="work_items[${rowCount}][progress_rate]" class="text w100p" value=""></td>
              <td class="report3">
                <select name="work_items[${rowCount}][status]" class="text w100p">
                  <option value="">진행중/완료</option>
                  <option value="진행중">진행중</option>
                  <option value="완료">완료</option>
                </select>
              </td>
              <td class="report4">
                <select name="work_items[${rowCount}][assignee]" class="text w100p">
                  <option value="">담당자 선택</option>
                </select>
              </td>
              <td class="report5"><div class="datepicker_area w100p"><input type="text" name="work_items[${rowCount}][start_date]" class="text datepicker w100p" value=""></div></td>
              <td class="report6"><div class="datepicker_area w100p"><input type="text" name="work_items[${rowCount}][end_date]" class="text datepicker w100p" value=""></div></td>
            </tr>`;
            var row = template.content.firstElementChild;
            tbody.appendChild(row);

            // 첫 행의 담당자 옵션을 새 행에도 복사
            var firstAssignee = tbody.querySelector('tr:first-child select[name$="[assignee]"]');
            var newAssignee = row.querySelector('select[name$="[assignee]"]');
            if (firstAssignee && newAssignee) {
                newAssignee.innerHTML = firstAssignee.innerHTML;
            }

            // 새 행의 순번 재계산
            Array.from(tbody.querySelectorAll('tr')).forEach(function (tr, idx) {
                var numCell = tr.querySelector('.num');
                if (numCell) { numCell.textContent = String(idx + 1); }
            });

            if (typeof CommonDatepicker !== 'undefined') {
                CommonDatepicker.init('.datepicker');
            }
        });
    }
});


