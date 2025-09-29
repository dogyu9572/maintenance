/**
 * 유지보수 요청 목록 페이지 JavaScript
 */

// 노트 모달 관련 함수들
function showNotesModal(requestId) {
    // 모달 표시
    document.querySelector('.pop_notes').style.display = 'block';
    
    // Fetch API로 노트 데이터 가져오기
    fetch(`/admin/maintenance-requests/${requestId}/notes`)
        .then(response => {
            if (!response.ok) {
                throw new Error('네트워크 응답이 올바르지 않습니다.');
            }
            return response.json();
        })
        .then(data => {
            // 노트 내역 설정
            const notesListContent = document.getElementById('notes_list_content');
            notesListContent.innerHTML = '';
            
            data.notes.forEach(note => {
                notesListContent.innerHTML += note + '<br>';
            });
        })
        .catch(error => {
            console.error('노트 데이터를 가져오는 중 오류 발생:', error);
            alert('노트 데이터를 가져오는 중 오류가 발생했습니다.');
        });
}

function closeNotesModal() {
    document.querySelector('.pop_notes').style.display = 'none';
}

// 페이지 로드 시 이벤트 리스너 등록
document.addEventListener('DOMContentLoaded', function() {
    // ESC 키로 모달 닫기
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNotesModal();
        }
    });

    // 모달 외부 클릭 시 닫기
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('dm')) {
            closeNotesModal();
        }
    });
});
