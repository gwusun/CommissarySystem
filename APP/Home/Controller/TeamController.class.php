<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/17
 * Time: 9:18
 */
namespace Home\Controller;
use Home\Model\TeamModel;
use Home\Model\UpWorkModel;

/**
 * Class UserController 团队控制器
 * @package Home\Controller
 */
class TeamController extends \Think\Controller
{

    private  $M;

    public function __construct()
    {
        parent::__construct();
        $this->M=new TeamModel();
    }

    public function addTeam()
    {
        $this->checkIsLogin();
        $catId=I('post.category');
        if($catId==-1){
            $this->error("没有选择课程！", U('UpWork/index'), 3);
        }
        /*
         * array(5) {
              ["teamName"]=>
              string(18) "我的分组系统"
              ["leaderName"]=>
              string(6) "张三"
              ["leaderNum"]=>
              string(3) "342"
              ["userName"]=>
              array(2) {
                [0]=>
                string(6) "李四"
                [1]=>
                string(12) "二恶烷若"
              }
              ["userNum"]=>
              array(2) {
                [0]=>
                string(5) "34324"
                [1]=>
                string(5) "23434"
              }
            }

*/
        $teamDate=array();
        $teamDate['cat_id']=I('post.category');
        $teamDate['t_project_name']=I('post.teamName');
        $teamDate['t_leader_name']=I('post.leaderName');
        $teamDate['t_leader_num']=I('post.leaderNum');
        $teamDate['user_stu_num']=session('user_stu_num');
        if($this->M->add($teamDate)){
            $this->success("添加成功", U('UpWork/index'), 3);
        }
    }

    public function modifyTeam(){
        $this->checkIsLogin();
        $tID=I('get.t_id');
        $this->isAccess($tID);

        //是否有权限访问

        $teamInfo=$this->M->getTeamInfo($tID);
        $this->assign("teamInfo",$teamInfo);

        $this->assign("catId",$teamInfo['cat_id']);
        $mUpWork=new UpWorkModel('team');
        $teamCategory=$mUpWork->getTeamCategory();
        $this->assign("teamCategory",$teamCategory);
        $this->display();
    }

    public function updateTeam()
    {
        $this->checkIsLogin();
        $id=I('post.t_id');
        $this->isAccess($id);
        /*
         * array(5) {
              ["teamName"]=>
              string(18) "我的分组系统"
              ["leaderName"]=>
              string(6) "张三"
              ["leaderNum"]=>
              string(3) "342"
              ["userName"]=>
              array(2) {
                [0]=>
                string(6) "李四"
                [1]=>
                string(12) "二恶烷若"
              }
              ["userNum"]=>
              array(2) {
                [0]=>
                string(5) "34324"
                [1]=>
                string(5) "23434"
              }
            }

*/
        if(!$this->M->clearOldDate($id)){
            die('删除就数据失败');
        }

        $teamDate=array();
        $teamDate['cat_id']=I('post.category');
        $teamDate['t_project_name']=I('post.teamName');
        $teamDate['t_leader_name']=I('post.leaderName');
        $teamDate['t_leader_num']=I('post.leaderNum');
        $teamDate['user_stu_num']=session('user_stu_num');
        if($this->M->add($teamDate)){
            $this->success("修改成功！！！", U('UpWork/index'), 3);
        }
    }


    
    /**
     * 检查是否登陆
     */
    public function checkIsLogin()
    {
        $stuNum=session('user_stu_num');
        if(!$stuNum){
            $this->success("尚未登陆，请登录后重试！", U('UpWork/index'), 3);
            exit;
        }
    }

    /**
     * 检查是否可以修改访问该项目
     */
    public function isAccess($id)
    {
        //检查是否ok
        if(!$this->M->checkIsAccess($id)){
            $this->success("你不是组长，不能修改！", U('UpWork/index'), 3);exit;
        }
    }

    public function delTeam()
    {
        $this->checkIsLogin();
        $id=I('get.t_id');
        $this->isAccess($id);
        if(!$this->M->clearOldDate($id)){

            $this->error("你不是组长，不能删除！", U('UpWork/index'), 3);exit;
        }else{
            $this->success("删除成功！", U('UpWork/index'), 3);exit;
        }
    }

    /**
     * ajax获取数据
     */
    public function getCategoryInfoByCatId()
    {
        $catId=I('get.catId');
        /*根据catId获取team*/

        $catTeam=$this->M->getCategoryInfoByCatId($catId);

        echo json_encode($catTeam);
    }
}