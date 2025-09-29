/**
 * 테이블 액션 관련 공통 JavaScript
 */

// 테이블 행 선택 기능
function selectTableRow(row) {
    // 모든 행의 선택 상태 제거
    document.querySelectorAll('.table-row').forEach(r => {
        r.classList.remove('selected');
    });
    
    // 선택된 행에 selected 클래스 추가
    row.classList.add('selected');
}

// 테이블 행 삭제 기능
function deleteTableRow(rowId) {
    if (confirm('정말 삭제하시겠습니까?')) {
        // AJAX 요청으로 삭제 처리
        fetch(`/admin/accounts/${rowId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 성공 시 행 제거
                const row = document.querySelector(`[data-id="${rowId}"]`);
                if (row) {
                    row.remove();
                }
            } else {
                alert('삭제 중 오류가 발생했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('삭제 중 오류가 발생했습니다.');
        });
    }
}

// 테이블 정렬 기능
function sortTable(column, direction = 'asc') {
    const table = document.querySelector('.table-sortable');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.querySelector(`td[data-column="${column}"]`)?.textContent || '';
        const bValue = b.querySelector(`td[data-column="${column}"]`)?.textContent || '';
        
        if (direction === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // 정렬된 행들을 다시 추가
    rows.forEach(row => tbody.appendChild(row));
}

// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function() {
    // 테이블 행 클릭 이벤트
    document.querySelectorAll('.table-row').forEach(row => {
        row.addEventListener('click', function() {
            selectTableRow(this);
        });
    });
    
    // 삭제 버튼 이벤트
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const rowId = this.getAttribute('data-id');
            deleteTableRow(rowId);
        });
    });
});
