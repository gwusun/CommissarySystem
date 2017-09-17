<?php
/**
 * Created by PhpStorm.
 * User: Sunwu
 * Date: 2017/8/17
 * Time: 9:18
 */
namespace Home\Controller;

/**
 * Class UserController 用户控制器
 * @package Home\Controller
 */
class UserController extends \Think\Controller
{


    private $M;//模型

    function __construct()
    {
        parent::__construct();
        $this->M = new \Home\Model\UserModel();
    }

    /**
     * 用户登陆
     */
    public function login()
    {
        $userName=I('post.login_username');
        $userPwd=I('post.login_pwd');
        $flag=strstr($userName,"@");
        if($flag){
            /*邮箱登陆*/
            $userInfo=$this->M->where(array('user_email' => $userName,'user_pwd'=>$userPwd))->find();
            if($userInfo){
                /*登陆成功*/
                session('user_stu_num',$userInfo['user_stu_num']);
                session('user_download_count',$userInfo['user_download_count']);
                session('user_name',$userInfo['user_name']);
                session('user_id',$userInfo['user_id']);
                /*更新登陆次数*/
                $this->M->updateLoginTimes($userInfo['user_stu_num']);
                $this->success("登陆成功", U('UpWork/index'), 0);

            }else{
                /*登陆失败*/
                $this->error("用户名或密码错误", U('UpWork/index'), 3);

            }
        }else{
           /*用户名登陆*/

            $userInfo=$this->M->where(array('user_stu_num' => $userName,'user_pwd'=>$userPwd))->find();
            $isActive=$userInfo['user_is_active'];
            if($isActive==='0'){
                $this->error("账户尚未激活,请登陆邮箱激活!", U('UpWork/index'), 99);
                exit;
            }
            if($userInfo){
                /*登陆成功*/
                session('user_download_count',$userInfo['user_download_count']);
                session('user_stu_num',$userInfo['user_stu_num']);
                session('user_name',$userInfo['user_name']);
                session('user_id',$userInfo['user_id']);
                session('user_email',$userInfo['user_email']);
                /*更新登陆次数*/
                $this->M->updateLoginTimes($userInfo['user_stu_num']);
                $this->success("登陆成功", U('UpWork/index'), 0);

            }else{
                /*登陆失败*/
                $this->error("用户名或密码错误", U('UpWork/index'), 3);

            }
        }

    }


    /**
     * 用户注册
     */
    public function register()
    {
        if(IS_POST){
           $info= $this->M->create();
            if ($this->M->add()) {
                $this->success("注册成功", U('UpWork/index'), 1);
           }else{
                $this->error("未知错误", U('UpWork/index'), 3);
            }
        }else{
            $this->display();
        }
    }


    /**
     * 注册时ajax检查邮箱使用
     */
    public function registerCheckEmail($email)
    {
        $emailPattern = "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
        $matchRes = preg_match($emailPattern, $email);
        $emailInfo = array();
        if ($matchRes) {
            /*获取邮箱*/
            $emails = array();
            $userInfo = $this->M->field("user_email")->select();
            foreach ($userInfo as $v) {
                $emails[] = $v['user_email'];
            }
            if (in_array($email, $emails)) {
                $emailInfo['stateMsg'] = "该邮箱已经存在,请换用其他邮箱";
            } else {
                $emailInfo['stateMsg'] = "邮箱可用";
                $emailInfo['state'] = 1;
            }
        } else {
            $emailInfo['stateMsg'] = "邮箱格式错误";
        }
        echo json_encode($emailInfo);
    }


    /**
     * 注册检查学号ajax
     * @param $email
     */
    public function registerCheckStuNum($email)
    {
        $emailPattern = "/^[0-9]{14}$/";
        $matchRes = preg_match($emailPattern, $email);
        $emailInfo = array();
        if ($matchRes) {
            /*获取学号*/
            $emails = array();
            $userInfo = $this->M->field("user_stu_num")->select();
            foreach ($userInfo as $v) {
                $emails[] = $v['user_email'];
            }
            if (in_array($email, $emails)) {
                $emailInfo['stateMsg'] = "该学号已经存在,请换用其他学号";
            } else {
                $emailInfo['stateMsg'] = "学号可用";
                $emailInfo['state'] = 1;
            }
        } else {
            $emailInfo['stateMsg'] = "学号格式错误";
        }
        echo json_encode($emailInfo);
    }


    /**
     * 检查验证码
     * @param $email
     */
    public function registerCheckVerify($verify)
    {
        $vry = new \Think\Verify();
        if ($vry->check($verify)) {
            echo json_encode(array('state' => 1));
        } else {
            echo json_encode(array('state' => 0));
        }
    }


    /**
     *验证码
     */
    function verifyImg()
    {
        ob_end_clean();
//        显示验证码
        $cfg = array(
            'imageH' => 35,               // 验证码图片高度
            'imageW' => 150,               // 验证码图片宽度
            'length' => 4,               // 验证码位数
//            'fontttf' => '4.ttf',              // 验证码字体，不设置随机获取
            'fontSize' => 18,              // 验证码字体大小(px)
        );
        $very = new \Think\Verify($cfg);
        $very->entry();
    }


    /**
     *推出登陆
     */
    function logout(){
        session(null);
        $this->success("注销成功", U('UpWork/index'), 1);
    }


    /**
     * 密码重置
     */
    public function reset()
    {
       $email=I('post.email');
       $stuNum=I('post.stu_no');
       $pwd=I('post.pwd1');
       if($this->M->resetUserPwd($email,$stuNum,$pwd)){
           $this->success("密码重置成功", U('UpWork/index'), 1);
       }else{
           $this->error("信息输入有误", U('UpWork/index'), 3);
       }
    }


    /**
     * 修改用户信息
     */
    public function modifyUserInfo()
    {
        $newName=I('post.name');
        $stuNum=I('post.stu_num');
        if($this->M->modifyUserInfo($newName,$stuNum)){
            $this->success("信息修改成功", U('UpWork/index'), 1);
        }else{
            $this->error("信息修改失败", U('UpWork/index'), 3);
        }
    }


    /**
     * 激活账号
     */
    public function activeUser()
    {
        $stuNum=I('get.user_stu_num');
        $checkCode=I('get.check_code');

        if($this->M->activeUser($stuNum,$checkCode)){
            $this->success("账号激活成功", U('UpWork/index'), 1);
        }else{
            $this->error("账号激活失败", U('UpWork/index'), 3);
        }
    }


    /**
     * ajax检查是否登陆
     */
    public function checkIsLoginByAjax()
    {
        /*查询控制台状态*/
        $conStatus=D('upwork_console')->field('con_switch')->find();

        $stuNum=session('user_stu_num');
        //state 1-已登陆 0-未登陆 3-未开启作业系统
        if(isset($stuNum)){
            if($conStatus['con_switch']=='off'){
                 echo  json_encode(array('state'=>3));exit;
            }
            echo  json_encode(array('state'=>1));
        }else{
            echo  json_encode(array('state'=>0));
        }
    }


    /**
     * 检查是否登陆
     */
    public function checkIsLogin()
    {
        $stuNum=session('user_stu_num');
        if(!$stuNum){
            $this->success("尚未登陆，请登录后重试", U('UpWork/index'), 3);
        }
    }
}