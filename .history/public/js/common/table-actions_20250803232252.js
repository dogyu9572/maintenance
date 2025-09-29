/**
 * 테이블 공통 액션 관리
 */
class TableActions {
    /**
     * 체크박스 전체 선택/해제 초기화
     */
    static initCheckboxes(allCheckSelector = "#allCheck", itemCheckSelector = "input[name='check']") {
        var $allCheck = $(allCheckSelector);
        var $itemChecks = $(itemCheckSelector);

        // 전체 선택 체크박스 이벤트
        $allCheck.change(function () {
            var checked = $(this).prop('checked');
            $itemChecks.prop('checked', checked);
        });

        // 개별 체크박스 이벤트
        $itemChecks.change(function () {
            var boxLength = $itemChecks.length;
            var checkedLength = $itemChecks.filter(':checked').length;
            var selectallCheck = (boxLength == checkedLength);
            $allCheck.prop('checked', selectallCheck);
        });
    }

    /**
     * 일괄 삭제 기능 초기화
     */
    static initBulkDelete(deleteButtonSelector = "#deleteSelected", itemCheckSelector = "input[name='check']", deleteUrl = null) {
        $(deleteButtonSelector).click(function() {
            var selectedIds = [];
            $(itemCheckSelector + ":checked").each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('삭제할 항목을 선택해주세요.');
                return;
            }

            if (confirm('선택한 항목을 삭제하시겠습니까?')) {
                $.ajax({
                    url: deleteUrl || $(this).data('delete-url'),
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('삭제 중 오류가 발생했습니다.');
                        }
                    },
                    error: function() {
                        alert('삭제 중 오류가 발생했습니다.');
                    }
                });
            }
        });
    }

    /**
     * 테이블 정렬 기능 초기화
     */
    static initSorting(sortableHeaders = "th[data-sort]") {
        $(sortableHeaders).click(function() {
            var column = $(this).data('sort');
            var currentOrder = $(this).data('order') || 'asc';
            var newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
            
            // URL 파라미터 업데이트
            var url = new URL(window.location);
            url.searchParams.set('sort', column);
            url.searchParams.set('order', newOrder);
            
            window.location.href = url.toString();
        });
    }

    /**
     * 페이지네이션 페이지 크기 변경
     */
    static initPageSizeChange(selector = "select[name='per_page']") {
        $(selector).change(function() {
            var url = new URL(window.location);
            url.searchParams.set('per_page', $(this).val());
            url.searchParams.delete('page'); // 페이지 크기 변경시 첫 페이지로
            window.location.href = url.toString();
        });
    }
} 