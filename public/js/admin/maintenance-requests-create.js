/**
 * 유지보수 요청 생성 페이지 JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // 폼 제출 시 유효성 검사
    const form = document.querySelector('#monthlyReportForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('필수 항목을 모두 입력해주세요.');
            }
        });
    }
});
