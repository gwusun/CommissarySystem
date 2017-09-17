<?php
namespace Plugins\Tools\File;
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/7/19
 * Time: 21:16
 */
require_once 'FileObject.class.php';
class FileDownload extends FileObject{

    /**
     * @param $fileName 需要下载的文件的全名
     */
    function downloadFile($fileName)
    {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . basename($fileName)); //文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: ' . filesize($fileName)); //告诉浏览器，文件大小
        @readfile($fileName);
    }

}