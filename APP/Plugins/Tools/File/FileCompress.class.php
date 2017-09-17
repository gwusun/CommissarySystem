<?php

namespace Plugins\Tools\File;

use ZipArchive;

/**
 * 文件压缩类
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/7/19
 * Time: 18:19
 */
require_once 'FileObject.class.php';

class FileCompress extends FileObject
{

    private $compressFileName; //压缩文件全名
    private $compressPath; //需要压缩的路径
    private $log; //压缩日志


    /**
     * @return mixed获取日志
     */
    public function getLog()
    {
        return $this->log;
    }


    /**
     * 获得压缩文件
     * @param $fileName 保存的压缩文件名
     * @param $fileList 需要添加的文件数组
     */
    public function getZip($compressPath, $compressFileName)
    {
        $this->compressFileName = $compressFileName;
        $this->compressPath = $compressPath;
        $fileName = $this->compressFileName;
        $fileList = $this->getFileList($this->compressPath);
        $log = "开始载入文件<hr>";
        $zip = new ZipArchive();
        if ($zip->open($fileName, ZipArchive::CREATE) === true) {
            foreach ($fileList as $item) {

                //处理压缩时的文件会出现绝对路径的问题
                $pos = strrpos($item, $this->DS);
                $localName = substr($item, $pos + 1);
                //解决乱码问题
                $localName=iconv('utf-8','gbk',$localName);
                if ($zip->addFile($item, $localName)) {
//                $log.="添加文件:{$item}----成功<br/>"
                    $log .= "文件[ {$item} ]----载入成功<br/>";
                } else {
                    die('无法添加文件');
                }

            }
            if ($zip->close()) {
                $fileName = $this->compressFileName;
                $pos = strrpos($fileName, $this->DS);
                $fileName = substr($fileName, $pos + 1);
                $log .= "<hr>开始创建压缩文件...<br>" . "[ " . $fileName . " ]" . "压缩包创建完成";
                $this->log = $log;

            } else {
                die("文件压缩处创建文件失败");
            }
        } else {
            die('无法打开文件');
        }
    }

    public function getCompressFileSavePathInfo()
    {
        $this->writeZipFilePathToFile();
        return $this->compressFileName;
    }


    /**
     * Compress constructor.
     * @param $compressPath 需要压缩的文件夹
     * @param $compressFileName 压缩文件名  ,带全路径
     */


    private function writeZipFilePathToFile()
    {
        if (!file_put_contents('./Uploads/downloadInfo.txt', $this->compressFileName)) {
            die("写入文件下载信息[ ".$this->compressFileName." ]失败;");
        }
    }

    function getDownloadAddress()
    {
        $url = file_get_contents('./Uploads/downloadInfo.txt');
        if ($url) {
            return $url;
        } else {
            die("获取文件下载地址失败!");
        }
    }

}
////define('DS', DIRECTORY_SEPARATOR);
//////define("COMPRESS_PATH", 'C:\xampp\htdocs\Uploads\mysql'. DS);
//////define("COMPRESS_SAVE_PATH", getcwd() . DS);
//////$compressFileName = COMPRESS_SAVE_PATH . "test.zip";
//$com = new FileCompress.class("./","./sunwu.zip");
//$com->getZip();
//$f2=$com->getLog();
//$f1=$com->getCompressFileSavePathInfo();
////$fileList=1;