<?php
namespace Admin\Controller;

use Admin\Model\UpWorkConsoleModel;

class UpWorkConsoleController extends \Think\Controller{
    private  $file;

    private $work_name;


    private $M;//模型

    function __construct()
    {
        parent::__construct();
        $this->M=new UpWorkConsoleModel('upwork_console');//初始化模型
        if(session('user_stu_num')!=='20150107030131'){
            $this->error("无权限访问", U('Home/UpWork/index'), 3);
        }
    }


    public function showConsole()
    {
        if (IS_POST) {
            $this->M->create();
            if($this->M->where(array('con_id' => 1))->save()){
                $this->success("修改成功", U('showConsole'), 3);
            }else{
                $this->error("失败", U('showConsole'), 3);
            }
        } else {

            /*获取控制台数据*/
            $conInfo=$this->M->find();
            $this->assign("conInfo",$conInfo);

            /*获取文件自动保存名称*/
            $fileSaveName= getFileName();
            $this->assign('fileSaveName', $fileSaveName);


            $this->display();
        }
    }
    
    /**
     * 删除全部文件
     */
    function deleteAllFile()
    {
        $m = D('upwork');
        $sql="update blog_upwork set work_is_del='已删除'";

        $m->execute($sql);
        $ft=new \Plugins\Tools\File\FileDelete();
        $ft->delFolder($this->getCompressPath());
        $this->success("删除成功", U('showConsole'), 3);
    }

    /**
     * 获得文件压缩路径
     * @return string 压缩的文件夹
     */
    private function getCompressPath(){
        $mCom=D('upwork_console');
        $conInfo=$mCom->find();

        $rootPath=$conInfo['con_save_root'];
        $savePath=$conInfo['con_save_path'];

        $dirPath=$rootPath.substr($savePath,2);
        return $dirPath;
    }

    /**
     * 获取文件名
     * @return \转化后的字符串
     */
    function getZipFileName(){
        $m = D('upwork_console');
        $info = $m->find();
        $str = $info['con_grade'];
        $str .= $info['con_major'];
        $str .= $info['con_course'];
        $str .= $info['con_course_type'];
        $day = getdate($info['con_date']);
        $str .= $day['year'];
        $mon = $day['mon'];
        if ($mon < 10) {
            $str .= '0' . $mon;
        } else {
            $str .= $day['mon'];
        }
        $str .= $day['mday'];
        return $str;
    }

    /**
     * 压缩文件
     */
    function compressFile()
    {

        $compressPath=$this->getCompressPath();//压缩文件夹
        $mCom=D('upwork_console');
        $conInfo=$mCom->find();
        $rootPath=$conInfo['con_save_root'];
        $zipSavePath=$rootPath.temp."/";//压缩文件保存路径
        if(!file_exists($zipSavePath)){
            if(!mkdir($zipSavePath)){
                die("创建文件夹[ ".$zipSavePath." ]失败");
            }
        }


        $fileName=$this->getZipFileName();//文件名
        $compressFileName=$zipSavePath.$fileName.".zip";//压缩文件名,带路径
        $fc=new \Plugins\Tools\File\FileCompress();
        $fc->getZip($compressPath,$compressFileName);
        echo $log=$fc->getLog();

        $this->file=$fc->getCompressFileSavePathInfo();
        $url=U('UpWorkConsole/downloadFile');
        echo "<a href='$url'>下载文件</a>";
    }

    function downloadFile(){
        $fc=new \Plugins\Tools\File\FileCompress();
        $downInfo=$fc->getDownloadAddress();

        $fd=new \Plugins\Tools\File\FileDownload();
        $fd->downloadFile($downInfo);
    }

    function delCompressFile(){
        $fc= new \Plugins\Tools\File\FileDelete();
        $fc->delFolder("./Uploads/temp/");
        $this->success("删除压缩文件成功", U('showConsole'), 3);
    }

}