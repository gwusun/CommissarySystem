<?php
namespace Plugins\Tools\File;
/**
 * 文件操作类
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/7/19
 * Time: 21:04
 */

require_once 'FileObject.class.php';
class FileDelete extends FileObject {

    /**
     * 删除文件夹
     * @param $dir 要删除的文件夹
     */
    function delFolder($dir){
        $fileList=$this->getFileList($dir);
        foreach ($fileList as $item){
            $this->delOneFile($item);
        }
        if(!rmdir($dir)){
            die('删除文件夹失败');
        }
    }

    /**
     * @param $dir 文件名称(包含路径)
     */
    function delOneFile($fileName){
        if(file_exists($fileName)){
            if(!unlink($fileName)){
                return false;
            }
        }
        return true;
    }

}
//$c=new FileDelete();
//$c->delFolder('C:\xampp\htdocs\test\c\\');