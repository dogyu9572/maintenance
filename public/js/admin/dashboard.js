/**
 * 관리자 대시보드 페이지 JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
});

/**
 * 대시보드 초기화
 */
function initializeDashboard() {
    initializeClientList();
    initializeTabMenu();
    initializeStateFilter();
    initializeScrollHandler();
    initializeNotesModal();
}

/**
 * 비고 모달 초기화
 */
function initializeNotesModal() {
    console.log('모달 초기화 시작');
    
    // 모달 초기 숨김
    const modal = document.querySelector('.popup.pop_note');
    if (modal) {
        modal.style.display = 'none';
    }
    
    // ESC 키로 모달 닫기
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            console.log('ESC 키 감지');
            closeNotesModal();
        }
    });

    // 모달 외부 클릭 시 닫기
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('dm')) {
            console.log('모달 외부 클릭 감지');
            closeNotesModal();
        }
    });
    
    console.log('모달 초기화 완료');
}

/**
 * 고객사 목록 초기화
 */
function initializeClientList() {
    const clientLinks = document.querySelectorAll('.main_wrap .client_list a');
    clientLinks.forEach(link => {
        link.addEventListener('click', function() {
            document.querySelector('.pop_work_statistics').style.display = 'block';
        });
    });
}

/**
 * 모바일 탭 메뉴 초기화
 */
function initializeTabMenu() {
    const tabButtons = document.querySelectorAll('.mo_tab_menu a');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabIndex = this.className.match(/tab(\d+)/)[1];
            
            // 활성 탭 변경
            tabButtons.forEach(btn => btn.classList.remove('on'));
            this.classList.add('on');
            
            // 콘텐츠 영역 변경
            document.querySelectorAll('.mo_con').forEach(content => {
                content.classList.remove('on');
            });
            document.querySelector('.mo_con' + tabIndex).classList.add('on');
        });
    });
}

/**
 * 상태별 필터 초기화
 */
function initializeStateFilter() {
    const selectButton = document.querySelector('.mo_state_wrap .btn_select');
    const stateButtons = document.querySelectorAll('.mo_state_wrap .state_area .btn');
    
    if (selectButton) {
        selectButton.addEventListener('click', function() {
            document.querySelector('.mo_state_wrap').classList.toggle('on');
        });
    }
    
    stateButtons.forEach(button => {
        button.addEventListener('click', function() {
            // 상태 선택 UI 업데이트
            document.querySelector('.mo_state_wrap').classList.remove('on');
            document.querySelector('.btn_select').innerHTML = this.innerHTML;
            
            // 활성 상태 변경
            stateButtons.forEach(btn => btn.classList.remove('on'));
            this.classList.add('on');
            
            // 상태별 필터링
            const status = this.dataset.status;
            filterRequestsByStatus(status);
        });
    });
}

/**
 * 스크롤 핸들러 초기화
 */
function initializeScrollHandler() {
    window.addEventListener('scroll', function() {
        const pointFoot = document.getElementById('point_foot');
        if (pointFoot && window.scrollY > pointFoot.offsetTop) {
            document.querySelector('.main_wrap').classList.add('unfixed');
        } else {
            document.querySelector('.main_wrap').classList.remove('unfixed');
        }
    });
}

/**
 * 고객사 검색
 */
function searchClients() {
    const searchTerm = document.getElementById('clientSearch').value.toLowerCase();
    const clientLinks = document.querySelectorAll('.client_list a');
    
    clientLinks.forEach(link => {
        const clientName = link.textContent.toLowerCase();
        if (clientName.includes(searchTerm)) {
            link.style.display = 'block';
        } else {
            link.style.display = 'none';
        }
    });
}

/**
 * 작업통계 모달 표시
 */
function showWorkStatistics(clientId) {
    // 실제 구현에서는 API 호출로 데이터를 가져와야 함
    document.getElementById('workStatisticsTitle').textContent = '고객사 작업통계';
    document.getElementById('workStatisticsPeriod').textContent = '2024.01.11~2025.01.11';
    document.getElementById('workStatisticsTotal').textContent = '24';
    
    // 계약공수
    document.getElementById('contractPmHours').textContent = '10';
    document.getElementById('contractDesignHours').textContent = '10';
    document.getElementById('contractPubHours').textContent = '10';
    document.getElementById('contractDevHours').textContent = '10';
    
    // 운영공수
    document.getElementById('operationPmHours').textContent = '10';
    document.getElementById('operationDesignHours').textContent = '10';
    document.getElementById('operationPubHours').textContent = '10';
    document.getElementById('operationDevHours').textContent = '10';
    
    // 잔여공수
    document.getElementById('remainingPmHours').textContent = '10';
    document.getElementById('remainingDesignHours').textContent = '10';
    document.getElementById('remainingPubHours').textContent = '10';
    document.getElementById('remainingDevHours').textContent = '10';
    
    document.querySelector('.pop_work_statistics').style.display = 'block';
}

/**
 * 비고 모달 표시
 */
function showNotesModal(requestId) {
    console.log('모달 표시 시작:', requestId);
    
    // 모달 요소 찾기
    const modal = document.querySelector('.popup.pop_note');
    if (!modal) {
        console.error('모달 요소를 찾을 수 없습니다.');
        return;
    }
    
    // 모달 표시
    modal.style.display = 'block';
    console.log('모달 표시 완료');
}

/**
 * 비고 모달 닫기
 */
function closeNotesModal() {
    console.log('모달 닫기 시작');
    
    // 모달 요소 찾기
    const modal = document.querySelector('.popup.pop_note');
    if (!modal) {
        console.error('모달 요소를 찾을 수 없습니다.');
        return;
    }
    
    // 모달 숨김
    modal.style.display = 'none';
    console.log('모달 닫기 완료');
}

/**
 * 상태별 요청 필터링
 */
function filterRequestsByStatus(status) {
    const rows = document.querySelectorAll('.list tbody tr');
    
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = 'table-row';
        } else {
            const statusCell = row.querySelector('.statebox .state');
            if (statusCell && statusCell.classList.contains('i' + status)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
