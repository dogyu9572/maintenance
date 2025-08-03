/**
 * 계정 관리 페이지 JavaScript
 */
$(document).ready(function(){
    // 공통 기능 초기화
    CommonDatepicker.init();
    TableActions.initCheckboxes();
    TableActions.initBulkDelete("#deleteSelected", "input[name='check']");
    TableActions.initPageSizeChange();
}); 