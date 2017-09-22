/**
 * 阻止表单提交
 * @param formId
 */
function preventSubmit(formId) {
    $(function () {
        $('#'+formId).submit(function (e) {
            e.preventDefault();
        });
    });

}