<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/17
 * Time: 9:38
 */

namespace Home\Model;

class UpWorkModel extends \Think\Model
{

    /**
     * 获取控制台信息
     * @return mixed
     */
    public function getWorkConsoleInfo()
    {
        $mWorkConsole = D('upwork_console');
        return $mWorkConsole->field('con_course,con_course_type,con_date,con_request')->find();
    }

    /**
     * 获取旧文件信息
     * @param $info
     * @return bool|string
     */
    public function getOldFileName($info)
    {
        return substr($info['work_save_path'], 0);
    }

    /**
     * 应交作业人数
     * @return int
     */
    function getAllWorkCountAll()
    {
        $mUser = D('user');

        $all = count($mUser->where(array('user_is_stu' => '1'))->select());
        return $all;
    }

    /**
     * 未交学生数组
     * @return mixed
     */
    function getUnloadStudunt()
    {

        /*获取总学生*/
        $mUser = D('user');
        $allStu = $mUser->where(array('user_is_stu' => '1'))->field('user_stu_num')->select();
        $allStuInfo = array();
        foreach ($allStu as $value) {
            $allStuInfo[] = $value['user_stu_num'];

        }

        /*获取已上传的学生*/
        $uploadStu = $this->where("work_is_del = '未删除'")->field('work_stu_num')->select();
        $uploadStuInfo = array();
        foreach ($uploadStu as $value) {
            $uploadStuInfo[] = $value['work_stu_num'];

        }

        $unloadStudents = array_diff($allStuInfo, $uploadStuInfo);//只有学号

        return $this->getNameFromUsername($unloadStudents);//根据学号获得姓名
    }

    /**
     * 根据学号返回学号和姓名
     * @param $ids
     * @return mixed
     */
    function getNameFromUsername($ids)
    {
        $ids = implode($ids, ',');

        if (empty($ids)) return;//解决空ids时bug

        return D('user')->where("user_stu_num in  ($ids)")->field('user_name,user_stu_num')->select();
    }

    /**
     * 根据学号获得用户信息
     * @param $stuNum
     * @return mixed
     */
    public function getUserInfo($stuNum)
    {
        $mUser = D('user');
        return $userInfo = $mUser->where(array('user_stu_num' => $stuNum))->find();
    }

    /**
     * 保存用户下载次数
     * @param $userInfo
     */
    public function saveDownloadTimes($userInfo)
    {
        $stuNum = $userInfo['user_stu_num'];
        $oldDownloadTime = $userInfo['user_download_count'];
        $newDownloadTime = $oldDownloadTime + 1;
        $sql = "update blog_user set user_download_count=$newDownloadTime WHERE user_stu_num='$stuNum'";
        return $this->execute($sql);
    }


    /**
     * 根据作业id获取下载地址
     * @param $workId
     */
    public function getFileDownloadUrlFromId($workId)
    {
        $workInfo = $this->find($workId);
        return substr($workInfo['work_save_path'], 1);
    }


    /**
     * 连表查询获取信息
     */
    public function getTeamInfo()
    {
        //拼装sql语句 连表查询
        $sql = "select t.t_project_name,t.cat_id,t.t_leader_name,t.t_leader_num,tu.t_id,tu.tu_user_name,tu.tu_user_num from blog_team as t INNER JOIN blog_team_user as tu where t.t_id = tu.t_id";
        $res = $this->query($sql);

//        dump($res);echo "<hr>";
        $returnDate = array();
        $j = 0;
        $flag = 0;
        //两个数组拼装数据信息
        foreach ($res as $k => $v) {
            if ($flag == $v['t_id']) {
                /*当前的t_id在returnDate中*/
//                $returnDate[$j]['tu_user_name']=$returnDate[$j]['tu_user_name'].",".$v['tu_user_name'];
//                $returnDate[$j]['tu_user_num']=$returnDate[$j]['tu_user_num'].",".$v['tu_user_num'];
//                $returnDate[$j]['user_info']=$returnDate[$j]['user_info']."<br>".$v['tu_user_name'].$v['tu_user_num'];;
                $returnDate[$j]['user_info_1'][] = $v['tu_user_name'] . $v['tu_user_num'];
                $returnDate[$j]['tu_user_name'][] = $v['tu_user_name'];
                $returnDate[$j]['tu_user_num'][] = $v['tu_user_num'];

            } else {
                /*不在returnData中*/
                $flag = $v['t_id'];
                $j++;

                $returnDate[$j]['t_id'] = $v['t_id'];
                $returnDate[$j]['cat_id']=$v['cat_id'];
                $returnDate[$j]['cat_name'] = $this->getCatNameByCatId($v['cat_id']);
                $returnDate[$j]['t_project_name'] = $v['t_project_name'];
                $returnDate[$j]['t_leader_name'] = $v['t_leader_name'];
                $returnDate[$j]['t_leader_num'] = $v['t_leader_num'];
//                $returnDate[$j]['tu_user_name']=$v['tu_user_name'];
//                $returnDate[$j]['tu_user_num']=$v['tu_user_num'];
//                $returnDate[$j]['user_info']=$v['tu_user_name'].$v['tu_user_num'];
                $returnDate[$j]['user_info_1'][] = $v['tu_user_name'] . $v['tu_user_num'];
                $returnDate[$j]['tu_user_name'][] = $v['tu_user_name'];
                $returnDate[$j]['tu_user_num'][] = $v['tu_user_num'];

            }
//            if($flag!=$v['t_id']) $j++;

        }
        return $returnDate;
//        $mTeam=D('team');
//
//        $teamData=array();
//        $teamData=$mTeam->select();
//        $teamData[]=33;
//        dump($teamData);
    }

    /**
     * 获取分组信息
     * @return mixed
     */
    public function getTeamCategory()
    {
        $mTeamCat = D('team_category');
        return $mTeamCat->select();
    }


    /*
     * 根据catId获取名字
     * @return string 名字
     */
    public function getCatNameByCatId($catId)
    {
        $mCat = D('team_category');
        $sql = "select cat_name from blog_team_category WHERE cat_id=$catId";
        $data = $this->query($sql);
        $data = $data[0]['cat_name'];
        return $data;
    }

}