/**
 * 获取文件大小
 * @param inputId input元素的id
 * @return int 文件的大小（kb）
 */
function getFileSize(inputId) {
    var input = document.getElementById(inputId);
    var file = input.files[0];
    return Math.ceil(file.size/1024);
}

/**
 * 获取文件名
 * @param inputId input的id值
 */
function getFileName(inputId) {
    var input = document.getElementById(inputId);
    var file = input.files[0];
    return file.name;
}


/**
 * 获取文件mime
 * @param inputId input的id值
 */
function getFileMime(inputId) {
    var input = document.getElementById(inputId);
    var file = input.files[0];
    return file.type;
}

