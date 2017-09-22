<?php

namespace Home\Controller;

use Home\Model\UpWorkModel;
use Plugins\Tools\File\FileDelete;
use Think\Think;

/**
 * 作业上传控制器
 */
class UpWorkController extends \Think\Controller
{
    private $M;

    function __construct()
    {
        parent::__construct();
        $this->M = new UpWorkModel('upwork');
    }

    /**
     * 保存ajax上传文件
     */
    function fileSave()
    {
        if (!empty($_FILES)) {
            /*检查是否登陆  检查功能是否开启*/


            //实例化类，并设置上传参数
            $upload = new \Think\Upload();
            $upload->saveName = getFileName();
            $upload->savePath = getFileSavePath();
            $upload->autoSub = false;
            $upload->subName = false;
//            $upload->rootPath = getFileSaveRoot();
            $upload->replace = true;
            $info = $upload->upload();
//            dump($info);
            $upInfo=$info['upFile'];

            //返回参考信息
            $upInfoStatus="<h5 style='color: red'><hr>上传详情：</h5>"."上传文件原名：".$upInfo['name']."<br>";
            $upInfoStatus.="文件保存信息：".$upInfo['savepath'].$upInfo['savename']."<br>";
            $upInfoStatus.="上传文件大小：".$upInfo['size']."kb"."<br>";

            if ($info) {
                /*收集数据库保存信息*/
                $mWCon = D('upwork_console');
                $conInfo = $mWCon->find();
                $info = $info['upFile'];
                $saveInfo = array();
                $saveInfo['work_name'] = $info['savename'];
                $saveInfo['work_stu_num'] = session('user_stu_num');
                $saveInfo['work_add_date'] = time();
                $saveInfo['work_save_path'] = getFileSaveRoot() . substr(getFileSavePath(), 2) . $info['savename'];
                $saveInfo['work_course'] = $conInfo['con_course'];
                $saveInfo['work_course_type'] = $conInfo['con_course_type'];


                /*是否上传过*/
                $mUpWork = D('upwork');
                $username = session('user_stu_num');
                $oldWorkInfo = $mUpWork->where("work_stu_num={$username} and work_is_del='未删除'")->find();
                if (empty($oldWorkInfo)) {
                    /*没有上传过*/
                    $mUpWork->add($saveInfo);
                    echo "<h1 class='text-center'>文件上传成功</h1>";
                    echo $upInfoStatus;
                } else {
                    /*已上传过*/
                    $oldFile = $this->M->getOldFileName($oldWorkInfo);
                    $oldFileName = getFIleNameFromPath($oldFile);
                    $newFileName = $saveInfo['work_name'];

                    /*返回的消息*/
                    $str = <<<"end"
                    <h1 align="center" style="color: red">检测到重复提交文件</h1>
                    <h4 align="center" style="color: blue">系统将删除旧文件,保存新文件</h4>
                    
                    <p >删除旧文件中....</p>
                    <p >[ $oldFileName ]删除成功</p>
                    <p >保存新文件中...</p>
                    <p >[ $newFileName ]保存成功.</p>
                    
end;

                    /*删除就文件*/
                    $fd = new FileDelete();
                    if (file_exists($oldFile)) {
                        $fd->delOneFile($oldFile);
                    }
                    /*更新数据库信息*/
                    $mUpWork->where("work_stu_num={$username}")->save($saveInfo);

                    echo $str;
                    echo $upInfoStatus;
                }

            } else {
                $info=$upload->getError();
                echo "<h3 style='color: red;text-align: center'>$info</h3>";
            }
        } else {
            echo "没有文件上传";
        }

    }


    /**
     * 主界面
     */
    function index()
    {

        /*获取作业控制台信息*/
        $workConsoleInfo = $this->M->getWorkConsoleInfo();
        $this->assign("workConsoleInfo", $workConsoleInfo);

        /*获取文件名*/
        $fileSaveName = getFileName();
        $this->assign("fileSaveName", $fileSaveName);

        /* 已交作业输出*/
        $hasUploadedInfo = $this->M->where('work_is_del=\'未删除\'')->order('work_stu_num')->select();
        $okCount=count($hasUploadedInfo);
        $this->assign("okCount",$okCount);
        $this->assign('hasUploadedInfo', $hasUploadedInfo);

        /* 作业总份数*/
        $workCountAll = $this->M->getAllWorkCountAll();
        $this->assign("allCount",$workCountAll);
        $this->assign("workCountAll", $workCountAll);

        /*未交作业学生*/
        $unloadStudent = $this->M->getUnloadStudunt();
        $noCount=count($unloadStudent);
        $this->assign("noCount",$noCount);
        $this->assign("unloadStudent", $unloadStudent);

        /*获取分组详细*/
//        $teamInfo=$this->M->getTeamInfo();
//        $this->assign("teamInfo",$teamInfo);

        /*获取分组类别*/
        $teamCate=$this->M->getTeamCategory();
        $this->assign("teamCategory",$teamCate);

        /*获取用户信息*/
        $userInfo=$this->M->getUserInfo(session('user_stu_num'));
        $this->assign("userInfo",$userInfo);
        $this->display();
//        dump($teamCate);


    }

    /**
     * ajax请求自动获取下载地址
     */
    public function downloadFile($workId)
    {
        /*更新用户下载次数*/
        //status 0-成功 1-没有登陆 2-没有下载权限 3-意外错误
        $stuNum=session('user_stu_num');
        if(empty($stuNum)){
            echo json_encode(array('status'=>1));exit;
        }

        //获取用户信息
        $userInfo=$this->M->getUserInfo($stuNum);
        //检查用户权限
        if(!$userInfo['user_is_vip']==1){
            echo json_encode(array('status'=>2));exit;
        }


        //保存用户下载次数
        if(!$this->M->saveDownloadTimes($userInfo)){
            echo json_encode(array('status' => 3));exit;
        }

        /*获取文件下载地址*/
        $downloadUrl=$this->M->getFileDownloadUrlFromId($workId);
        echo json_encode(array('status'=>0,'downloadUrl'=>$downloadUrl));exit;
    }
}