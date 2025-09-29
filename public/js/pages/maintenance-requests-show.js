// 유지보수 요청 상세 페이지 JavaScript
// 작업공수 관리, 관리자 설정, 댓글 CRUD 기능

// 작업공수 저장
function saveWorkHours() {
    const expectedPmHours = document.getElementById('expected_pm_hours').value;
    const expectedDesignHours = document.getElementById('expected_design_hours').value;
    const expectedPubHours = document.getElementById('expected_pub_hours').value;
    const expectedDevHours = document.getElementById('expected_dev_hours').value;
    const actualPmHours = document.getElementById('actual_pm_hours').value;
    const actualDesignHours = document.getElementById('actual_design_hours').value;
    const actualPubHours = document.getElementById('actual_pub_hours').value;
    const actualDevHours = document.getElementById('actual_dev_hours').value;
    
    fetch(`/admin/maintenance-requests/${maintenanceRequestId}/work-hours`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            expected_pm_hours: expectedPmHours === '' ? 0 : (expectedPmHours || 0),
            expected_design_hours: expectedDesignHours === '' ? 0 : (expectedDesignHours || 0),
            expected_pub_hours: expectedPubHours === '' ? 0 : (expectedPubHours || 0),
            expected_dev_hours: expectedDevHours === '' ? 0 : (expectedDevHours || 0),
            actual_pm_hours: actualPmHours === '' ? 0 : (actualPmHours || 0),
            actual_design_hours: actualDesignHours === '' ? 0 : (actualDesignHours || 0),
            actual_pub_hours: actualPubHours === '' ? 0 : (actualPubHours || 0),
            actual_dev_hours: actualDevHours === '' ? 0 : (actualDevHours || 0),
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            updateWorkHoursStyle();
        } else {
            alert('작업공수 저장에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('작업공수 저장 중 오류가 발생했습니다.');
    });
}

// 작업공수 스타일 업데이트
function updateWorkHoursStyle() {
    const expectedPmHours = document.getElementById('expected_pm_hours').value;
    const expectedDesignHours = document.getElementById('expected_design_hours').value;
    const expectedPubHours = document.getElementById('expected_pub_hours').value;
    const expectedDevHours = document.getElementById('expected_dev_hours').value;
    
    const actualPmHours = document.getElementById('actual_pm_hours').value;
    const actualDesignHours = document.getElementById('actual_design_hours').value;
    const actualPubHours = document.getElementById('actual_pub_hours').value;
    const actualDevHours = document.getElementById('actual_dev_hours').value;
    
    // 예상공수 스타일 업데이트
    document.querySelector('#expected_pm_hours').closest('li').classList.toggle('in', expectedPmHours > 0 && expectedPmHours !== '');
    document.querySelector('#expected_design_hours').closest('li').classList.toggle('in', expectedDesignHours > 0 && expectedDesignHours !== '');
    document.querySelector('#expected_pub_hours').closest('li').classList.toggle('in', expectedPubHours > 0 && expectedPubHours !== '');
    document.querySelector('#expected_dev_hours').closest('li').classList.toggle('in', expectedDevHours > 0 && expectedDevHours !== '');
    
    // 실제공수 스타일 업데이트
    document.querySelector('#actual_pm_hours').closest('li').classList.toggle('in', actualPmHours > 0 && actualPmHours !== '');
    document.querySelector('#actual_design_hours').closest('li').classList.toggle('in', actualDesignHours > 0 && actualDesignHours !== '');
    document.querySelector('#actual_pub_hours').closest('li').classList.toggle('in', actualPubHours > 0 && actualPubHours !== '');
    document.querySelector('#actual_dev_hours').closest('li').classList.toggle('in', actualDevHours > 0 && actualDevHours !== '');
}

// 공수확인요청
function requestWorkHours() {
    alert('공수확인요청이 전송되었습니다.');
}

// 관리자 설정 저장
function saveAdminSettings() {
    const isUrgent = document.getElementById('is_urgent').checked;
    const workerId = document.getElementById('worker_id').value;
    const expectedDate = document.getElementById('expected_date').value;
    const notes = document.getElementById('notes').value;
    const issues = document.getElementById('issues').value;
    const reportTitle = document.getElementById('report_title').value;
    const progressRate = document.getElementById('progress_rate').value;
    const progressStatus = document.getElementById('progress_status').value;
    
    const requestData = {
        is_urgent: isUrgent,
        worker_id: workerId || null,
        expected_date: expectedDate || null,
        notes: notes,
        issues: issues,
        report_title: reportTitle,
        progress_rate: progressRate || 0,
        progress_status: progressStatus,
    };
    
    console.log('전송할 데이터:', requestData);
    
    fetch(`/admin/maintenance-requests/${maintenanceRequestId}/admin-settings`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        console.log('응답 상태:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('응답 데이터:', data);
        if (data.success) {
            alert(data.message);
        } else {
            alert('관리자 설정 저장에 실패했습니다: ' + (data.message || ''));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('관리자 설정 저장 중 오류가 발생했습니다.');
    });
}

// 댓글 작성
function addComment() {
    const content = document.getElementById('comment_content').value.trim();
    
    if (!content) {
        alert('댓글 내용을 입력해주세요.');
        return;
    }
    
    const requestData = {
        content: content,
        type: 'complete',
        parent_id: null
    };
    
    console.log('댓글 등록 요청 데이터:', requestData);
    
    fetch(`/admin/maintenance-requests/${maintenanceRequestId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        console.log('댓글 등록 응답 상태:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('댓글 등록 응답 데이터:', data);
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('댓글 작성에 실패했습니다: ' + (data.message || ''));
        }
    })
    .catch(error => {
        console.error('댓글 등록 오류:', error);
        alert('댓글 작성 중 오류가 발생했습니다.');
    });
}

// 댓글 수정 모드 전환
function editComment(commentId) {
    document.getElementById(`comment-content-${commentId}`).style.display = 'none';
    document.getElementById(`comment-edit-${commentId}`).style.display = 'block';
}

// 댓글 수정 취소
function cancelEdit(commentId) {
    document.getElementById(`comment-content-${commentId}`).style.display = 'block';
    document.getElementById(`comment-edit-${commentId}`).style.display = 'none';
}

// 댓글 수정 저장
function updateComment(commentId) {
    const content = document.getElementById(`edit-content-${commentId}`).value.trim();
    
    if (!content) {
        alert('댓글 내용을 입력해주세요.');
        return;
    }
    
    fetch(`/admin/maintenance-requests/${maintenanceRequestId}/comments/${commentId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            content: content
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('댓글 수정에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('댓글 수정 중 오류가 발생했습니다.');
    });
}

// 댓글 삭제
function deleteComment(commentId) {
    if (!confirm('정말 삭제하시겠습니까?')) {
        return;
    }
    
    fetch(`/admin/maintenance-requests/${maintenanceRequestId}/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('댓글 삭제에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('댓글 삭제 중 오류가 발생했습니다.');
    });
}

// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function() {
    // 작업공수 스타일 초기화
    updateWorkHoursStyle();
});
