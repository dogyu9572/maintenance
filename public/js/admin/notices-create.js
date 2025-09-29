document.addEventListener('DOMContentLoaded', function() {
    const MAX_FILES = 3;
    let uploadedFiles = [];

    // DOM 요소들
    const form = document.querySelector('form');
    const fileInput = document.getElementById('file-input');
    const fileBox = document.querySelector('.file_box');

    // 이벤트 리스너 등록
    form.addEventListener('submit', handleFormSubmit);
    fileInput.addEventListener('change', handleFileChange);

    // 폼 제출 핸들러
    function handleFormSubmit(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return false;
        }
        
        submitForm();
    }

    // 폼 검증
    function validateForm() {
        const title = document.querySelector('input[name="title"]').value.trim();
        const content = document.querySelector('textarea[name="content"]').value.trim();
        
        if (!title) {
            alert('제목을 입력해주세요.');
            return false;
        }
        
        if (!content) {
            alert('내용을 입력해주세요.');
            return false;
        }
        
        return true;
    }

    // 폼 제출 (Fetch API 사용)
    async function submitForm() {
        try {
            const formData = new FormData(form);
            
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message || '저장 중 오류가 발생했습니다.');
            }
        } catch (error) {
            alert(error.message);
        }
    }

    // 파일 변경 핸들러
    function handleFileChange(e) {
        const files = Array.from(e.target.files);
        const currentFileCount = fileBox.querySelectorAll('button').length;
        
        if (files.length + currentFileCount > MAX_FILES) {
            alert(`최대 ${MAX_FILES}개의 파일만 업로드할 수 있습니다.`);
            return;
        }
        
        files.forEach((file, index) => {
            if (currentFileCount + index >= MAX_FILES) return;
            
            addFileButton(file);
        });
        
        updateFileInput();
        toggleFileBoxClass();
    }

    // 파일 버튼 추가
    function addFileButton(file) {
        const fileButton = document.createElement('button');
        fileButton.type = 'button';
        fileButton.className = 'del';
        fileButton.textContent = file.name;
        
        const fileIndex = uploadedFiles.length;
        uploadedFiles.push(file);
        
        fileButton.addEventListener('click', function() {
            removeFile(fileIndex);
            this.remove();
            updateFileInput();
            toggleFileBoxClass();
        });
        
        fileBox.appendChild(fileButton);
    }

    // 파일 제거
    function removeFile(index) {
        uploadedFiles.splice(index, 1);
    }

    // 파일 입력 업데이트
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // 파일 박스 클래스 토글
    function toggleFileBoxClass() {
        const hasFiles = fileBox.querySelectorAll('button').length > 0;
        fileBox.classList.toggle('on', hasFiles);
    }
});
